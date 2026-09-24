<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function showLogin()
    {
        return view('account.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($validated, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user && $user->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('account.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('account.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
        ]);

        Auth::login($user);

        return redirect()->route('account.dashboard')->with('success', 'Registration successful');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = $user->orders()->latest()->limit(5)->get();

        return view('account.dashboard', compact('recentOrders'));
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }

    public function orders(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->latest()
            ->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product.images', 'payments', 'shipments']);

        return view('account.order-detail', compact('order'));
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()->orderByDesc('is_default')->get();

        return view('account.addresses', compact('addresses'));
    }

    public function createAddress()
    {
        return view('account.address-form');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        if (! empty($validated['is_default'])) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Auth::user()->addresses()->create($validated);

        return redirect()->route('account.addresses')->with('success', 'Address added successfully');
    }

    public function editAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('account.address-form', compact('address'));
    }

    public function updateAddress(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        if (! empty($validated['is_default'])) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('account.addresses')->with('success', 'Address updated successfully');
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', 'Address deleted successfully');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}
