@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-navy">Delivery Location</h1>
            <p class="mt-2 text-navy/60">Set your delivery location to see accurate shipping costs and delivery times</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-800 p-4 rounded-lg text-sm mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('deliver.to.update') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="province" class="block text-sm font-medium text-navy mb-2">Province <span class="text-red-500">*</span></label>
                <select id="province" name="province_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors appearance-none bg-white">
                    <option value="">Select Province</option>
                    <option value="1" {{ old('province_id') == '1' ? 'selected' : '' }}>DKI Jakarta</option>
                    <option value="2" {{ old('province_id') == '2' ? 'selected' : '' }}>Jawa Barat</option>
                    <option value="3" {{ old('province_id') == '3' ? 'selected' : '' }}>Jawa Timur</option>
                    <option value="4" {{ old('province_id') == '4' ? 'selected' : '' }}>Bali</option>
                    <option value="5" {{ old('province_id') == '5' ? 'selected' : '' }}>Sumatera Utara</option>
                </select>
                @error('province_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="city" class="block text-sm font-medium text-navy mb-2">City / Regency <span class="text-red-500">*</span></label>
                <select id="city" name="city_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors appearance-none bg-white"
                    disabled>
                    <option value="">Select Province First</option>
                </select>
                @error('city_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-3 px-4 bg-navy text-white rounded-lg font-medium hover:bg-navy/90 transition-colors">
                    Save Delivery Location
                </button>
            </div>
        </form>

        {{-- Current Location Display --}}
        @if(session('delivery_province_id') || session('delivery_city_id'))
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-navy mb-2">Current Delivery Location</h3>
                <div class="text-sm text-navy/60">
                    @php
                        $provinces = [
                            '1' => 'DKI Jakarta',
                            '2' => 'Jawa Barat',
                            '3' => 'Jawa Timur',
                            '4' => 'Bali',
                            '5' => 'Sumatera Utara'
                        ];
                        $cities = [
                            '1' => ['1' => 'Jakarta Pusat', '2' => 'Jakarta Utara', '3' => 'Jakarta Selatan', '4' => 'Jakarta Barat', '5' => 'Jakarta Timur'],
                            '2' => ['6' => 'Bandung', '7' => 'Bekasi', '8' => 'Depok', '9' => 'Bogor'],
                            '3' => ['10' => 'Surabaya', '11' => 'Sidoarjo', '12' => 'Malang'],
                            '4' => ['13' => 'Denpasar', '14' => 'Kuta', '15' => 'Ubud'],
                            '5' => ['16' => 'Medan', '17' => 'Binjai', '18' => 'Deli Serdang']
                        ];
                        $provinceId = session('delivery_province_id');
                        $cityId = session('delivery_city_id');
                    @endphp
                    @if($provinceId && isset($provinces[$provinceId]))
                        <p>{{ $provinces[$provinceId] }}{{ $cityId && isset($cities[$provinceId][$cityId]) ? ', ' . $cities[$provinceId][$cityId] : '' }}</p>
                    @endif
                </div>
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('shop') }}" class="text-primary hover:underline font-medium">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        
        // Sample city data
        const citiesByProvince = {
            '1': [
                {id: '1', name: 'Jakarta Pusat'},
                {id: '2', name: 'Jakarta Utara'},
                {id: '3', name: 'Jakarta Selatan'},
                {id: '4', name: 'Jakarta Barat'},
                {id: '5', name: 'Jakarta Timur'}
            ],
            '2': [
                {id: '6', name: 'Bandung'},
                {id: '7', name: 'Bekasi'},
                {id: '8', name: 'Depok'},
                {id: '9', name: 'Bogor'}
            ],
            '3': [
                {id: '10', name: 'Surabaya'},
                {id: '11', name: 'Sidoarjo'},
                {id: '12', name: 'Malang'}
            ],
            '4': [
                {id: '13', name: 'Denpasar'},
                {id: '14', name: 'Kuta'},
                {id: '15', name: 'Ubud'}
            ],
            '5': [
                {id: '16', name: 'Medan'},
                {id: '17', name: 'Binjai'},
                {id: '18', name: 'Deli Serdang'}
            ]
        };

        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            
            // Reset city select
            citySelect.innerHTML = '<option value="">Select City</option>';
            citySelect.disabled = !provinceId;
            
            if (provinceId && citiesByProvince[provinceId]) {
                citiesByProvince[provinceId].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            }
        });
    });
</script>
@endpush