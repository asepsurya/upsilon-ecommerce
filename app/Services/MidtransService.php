<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        $environment = Setting::get('midtrans_environment', 'sandbox');
        $isProduction = $environment === 'production';

        Config::$serverKey = Setting::get('midtrans_server_key', config('services.midtrans.server_key'));
        Config::$clientKey = Setting::get('midtrans_client_key', config('services.midtrans.client_key'));
        Config::$isProduction = $isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Create Snap token for payment
     */
    public function createSnapToken(Order $order): ?string
    {
        try {
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->total,
                ],
                'customer_details' => [
                    'first_name' => $order->shipping_name ?? $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->shipping_phone ?? $order->user->phone,
                    'billing_address' => $this->formatAddress($order->shipping_address ?? []),
                    'shipping_address' => $this->formatAddress($order->shipping_address ?? []),
                ],
                'item_details' => $this->formatItems($order),
                'callbacks' => [
                    'finish' => route('checkout.success', $order),
                    'error' => route('checkout.index'),
                    'pending' => route('checkout.index'),
                ],
                'expiry' => [
                    'start_time' => now()->format('Y-m-d H:i:s T'),
                    'unit' => 'hour',
                    'duration' => 24,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);

            return null;
        }
    }

    /**
     * Handle Midtrans notification (webhook)
     */
    public function handleNotification(Request $request): array
    {
        $notification = $request->all();

        $orderNumber = $notification['order_id'] ?? null;
        $transactionStatus = $notification['transaction_status'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;
        $paymentType = $notification['payment_type'] ?? null;

        if (! $orderNumber || ! $transactionStatus) {
            return ['status' => 'error', 'message' => 'Invalid notification data'];
        }

        $order = Order::where('order_number', $orderNumber)->first();

        if (! $order) {
            return ['status' => 'error', 'message' => 'Order not found'];
        }

        // Map Midtrans status to our order status
        $statusMap = [
            'capture' => 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'cancelled',
        ];

        $newPaymentStatus = $statusMap[$transactionStatus] ?? 'pending';

        // For credit card, check fraud status
        if ($paymentType === 'credit_card' && $fraudStatus) {
            if ($fraudStatus === 'challenge') {
                $newPaymentStatus = 'pending'; // Challenge by FDS
            } elseif ($fraudStatus === 'deny') {
                $newPaymentStatus = 'failed';
            }
        }

        $order->update([
            'payment_status' => $newPaymentStatus,
            'status' => in_array($newPaymentStatus, ['paid']) ? 'processing' : $order->status,
        ]);

        $order->payments()->latest()->first()?->update([
            'status' => $newPaymentStatus,
            'payload' => $notification,
        ]);

        Log::info('Midtrans notification processed', [
            'order_number' => $orderNumber,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $paymentType,
            'new_payment_status' => $newPaymentStatus,
        ]);

        return ['status' => 'success'];
    }

    /**
     * Format address for Midtrans
     */
    private function formatAddress(array $address): array
    {
        return [
            'first_name' => $address['full_name'] ?? '',
            'address' => $address['address'] ?? '',
            'city' => $address['city'] ?? '',
            'postal_code' => $address['postal_code'] ?? '',
            'phone' => $address['phone'] ?? '',
        ];
    }

    /**
     * Format order items for Midtrans
     */
    private function formatItems(Order $order): array
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'id' => $item->product_variant_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name.' ('.($item->size_name ?? '-').'/'.($item->color_name ?? '-').')',
            ];
        }

        // Add shipping cost as item if exists
        if ($order->shipping_cost > 0) {
            $items[] = [
                'id' => 'shipping',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman ('.$order->shipping_courier.')',
            ];
        }

        return $items;
    }

    /**
     * Check if Midtrans is configured
     */
    public function isConfigured(): bool
    {
        return ! empty(Setting::get('midtrans_server_key', config('services.midtrans.server_key')))
            && ! empty(Setting::get('midtrans_client_key', config('services.midtrans.client_key')))
            && ! empty(Setting::get('midtrans_merchant_id', config('services.midtrans.merchant_id')));
    }

    /**
     * Get checkout mode from settings
     */
    public static function getCheckoutMode(): string
    {
        return Setting::get('checkout_mode', 'midtrans');
    }

    /**
     * Get WhatsApp number from settings
     */
    public static function getWhatsAppNumber(): string
    {
        return Setting::get('whatsapp_number', config('services.whatsapp.number', '6281234567890'));
    }

    /**
     * Get default WhatsApp message
     */
    public static function getWhatsAppMessage(array $replacements = []): string
    {
        $message = Setting::get('whatsapp_default_message', config('services.whatsapp.default_message', 'Hello, I would like to inquire about your products.'));

        foreach ($replacements as $key => $value) {
            $message = str_replace('{'.$key.'}', $value, $message);
        }

        return $message;
    }

    /**
     * Build checkout confirmation WhatsApp message for an order
     */
    public static function buildCheckoutMessage(Order $order): string
    {
        $lines = [];
        $lines[] = 'Halo, saya ingin konfirmasi pembayaran pesanan.';
        $lines[] = '';
        $lines[] = 'Nomor Pesanan: '.$order->order_number;
        $lines[] = 'Tanggal: '.$order->created_at->format('d M Y');
        $lines[] = 'Total: '.currency_format($order->total);
        $lines[] = '';
        $lines[] = 'Detail Produk:';

        foreach ($order->items as $item) {
            $lines[] = '- '.$item->product_name.' ('.$item->size_name.'/'.$item->color_name.') x'.$item->quantity.' = '.currency_format($item->subtotal);
        }

        $lines[] = '';
        $lines[] = 'Saya akan mengirim bukti pembayaran.';

        return implode("\n", $lines);
    }
}
