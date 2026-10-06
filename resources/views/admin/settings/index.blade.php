@extends('admin.layouts.admin')

@section('title', 'Pengaturan | Upsilon')

@section('page-title', 'Pengaturan')

@section('breadcrumb')
    <nav class="admin-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Pengaturan</span>
    </nav>
@endsection

@section('content')
@php
    $groupCount = count($groups);
    $totalFields = collect($groups)->sum(fn ($group) => count($group['fields'] ?? []));
@endphp

<form method="POST" action="{{ route('admin.settings.update') }}" class="settings-form" data-settings-form>
    @csrf

    @if ($errors->any())
        <div class="admin-card !border-red-500 dark:!border-red-500 !bg-red-50 dark:!bg-red-950/30 !mb-6">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-red-500">error</span>
                <div>
                    <h3 class="admin-card-title !text-red-600 dark:!text-red-400">{{ $errors->count() }} nilai gagal disimpan</h3>
                    <p class="admin-card-description">Periksa kembali kolom yang ditandai merah di bawah, lalu simpan ulang.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[248px_minmax(0,1fr)] gap-6 items-start">
        {{-- Group navigation --}}
        <aside class="lg:sticky lg:top-24">
            <div class="admin-card !mb-0 !p-3">
                <p class="px-2 pt-1 pb-2 text-[11px] font-semibold uppercase tracking-wide text-[hsl(var(--muted-foreground))]">
                    {{ $groupCount }} kelompok
                </p>

                <nav class="flex flex-col gap-1" aria-label="Kelompok pengaturan">
                    <button type="button" class="settings-nav-item active" data-settings-nav="all">
                        <span class="material-symbols-outlined text-lg">apps</span>
                        <span class="flex-1 text-left">Semua Pengaturan</span>
                    </button>

                    @foreach ($groups as $groupKey => $group)
                        @php
                            $filled = collect($group['fields'] ?? [])->filter(fn ($field, $key) => filled(old($key, $data[$key] ?? '')))->count();
                            $fieldCount = count($group['fields'] ?? []);
                        @endphp
                        <button type="button" class="settings-nav-item" data-settings-nav="{{ $groupKey }}">
                            <span class="material-symbols-outlined text-lg">{{ $group['icon'] ?? 'tune' }}</span>
                            <span class="flex-1 min-w-0 text-left">
                                <span class="block truncate">{{ $group['label'] }}</span>
                                <span class="block text-[11px] font-normal text-[hsl(var(--muted-foreground))]">{{ $filled }}/{{ $fieldCount }} terisi</span>
                            </span>
                        </button>
                    @endforeach
                </nav>
            </div>

            <div class="admin-card !mb-0 mt-4 !p-4">
                <div class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-lg text-[hsl(var(--muted-foreground))]">info</span>
                    <p class="m-0 text-xs leading-relaxed text-[hsl(var(--muted-foreground))]">
                        Perubahan langsung berlaku di seluruh situs setelah disimpan. Kolom kosong berarti nilai tersebut tidak dipakai.
                    </p>
                </div>
            </div>
        </aside>

        {{-- Grouped sections --}}
        <div class="min-w-0">
            @foreach ($groups as $groupKey => $group)
                @php
                    $fields = $group['fields'] ?? [];
                    $hasErrorInGroup = collect(array_keys($fields))->contains(fn ($key) => $errors->has($key));
                @endphp

                <section
                    id="group-{{ $groupKey }}"
                    class="admin-card mb-6 scroll-mt-24 @if ($hasErrorInGroup) !border-red-500 dark:!border-red-500 @endif"
                    data-settings-group="{{ $groupKey }}"
                >
                    <div class="admin-card-header !mb-6 items-start gap-4">
                        <div class="settings-group-icon">
                            <span class="material-symbols-outlined">{{ $group['icon'] ?? 'tune' }}</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="admin-card-title">{{ $group['label'] }}</h2>
                                <span class="admin-badge admin-badge-info !text-[10px] !py-0.5 !px-2">
                                    {{ count($fields) }} kolom
                                </span>
                                @if ($hasErrorInGroup)
                                    <span class="admin-badge admin-badge-danger !text-[10px] !py-0.5 !px-2">Perlu diperbaiki</span>
                                @endif
                            </div>
                            @if (! empty($group['description']))
                                <p class="admin-card-description mt-1 max-w-2xl">{{ $group['description'] }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        @foreach ($fields as $fieldKey => $field)
                            @include('admin.settings._field', [
                                'key' => $fieldKey,
                                'field' => $field,
                                'value' => $data[$fieldKey] ?? '',
                            ])
                        @endforeach
                    </div>

                    {{-- Live previews --}}
                    @if ($groupKey === 'currency')
                        <div class="mt-6 rounded-[var(--radius)] border border-dashed border-[hsl(var(--border))] bg-[hsl(var(--muted))] p-4">
                            <p class="mb-3 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[hsl(var(--muted-foreground))]">
                                <span class="material-symbols-outlined text-base">preview</span>
                                Pratinjau format harga
                            </p>
                            <div class="flex flex-wrap items-center gap-2 font-mono text-sm">
                                <span class="rounded-[var(--radius)] border border-[hsl(var(--border))] bg-[hsl(var(--card))] px-3 py-1.5" data-currency-preview="1500000">—</span>
                                <span class="rounded-[var(--radius)] border border-[hsl(var(--border))] bg-[hsl(var(--card))] px-3 py-1.5" data-currency-preview="99000">—</span>
                                <span class="rounded-[var(--radius)] border border-[hsl(var(--border))] bg-[hsl(var(--card))] px-3 py-1.5" data-currency-preview="0">—</span>
                            </div>
                            <p class="mt-2 mb-0 text-xs text-[hsl(var(--muted-foreground))]">Simulasi produk, varian, dan diskon.</p>
                        </div>
                    @endif

                    @if ($groupKey === 'whatsapp')
                        <div class="mt-6 rounded-[var(--radius)] border border-dashed border-[hsl(var(--border))] bg-[hsl(var(--muted))] p-4">
                            <p class="mb-2 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[hsl(var(--muted-foreground))]">
                                <span class="material-symbols-outlined text-base">preview</span>
                                Tautan yang dihasilkan
                            </p>
                            <code class="block truncate rounded-[var(--radius)] border border-[hsl(var(--border))] bg-[hsl(var(--card))] px-3 py-2 font-mono text-xs" data-whatsapp-preview>—</code>
                            <p class="mt-2 mb-0 text-xs text-[hsl(var(--muted-foreground))]">Pastikan nomor tanpa tanda + agar tautan wa.me valid.</p>
                        </div>
                    @endif

                    @if ($groupKey === 'social')
                        <div class="mt-6 rounded-[var(--radius)] border border-dashed border-[hsl(var(--border))] bg-[hsl(var(--muted))] p-4">
                            <p class="mb-2 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[hsl(var(--muted-foreground))]">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                Ikon yang tampil di footer
                            </p>
                            <div class="flex flex-wrap gap-2" data-social-preview></div>
                            <p class="mt-2 mb-0 text-xs text-[hsl(var(--muted-foreground))]">Ikon dengan tautan kosong disembunyikan otomatis dari situs.</p>
                        </div>
                    @endif
                </section>
            @endforeach

            {{-- Save bar --}}
            <div class="admin-card sticky bottom-4 z-20 !mb-0 flex flex-wrap items-center justify-between gap-3 shadow-lg backdrop-blur">
                <p class="m-0 flex items-center gap-2 text-xs text-[hsl(var(--muted-foreground))]" data-dirty-indicator>
                    <span class="material-symbols-outlined text-base">cloud_done</span>
                    <span>Semua perubahan tersimpan</span>
                </p>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-[hsl(var(--muted-foreground))]">{{ $totalFields }} kolom di {{ $groupCount }} kelompok</span>
                    <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn-secondary">Batal</a>
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 9px 12px;
        border: none;
        border-radius: var(--radius);
        background: none;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 500;
        color: hsl(var(--foreground));
        cursor: pointer;
        text-align: left;
        transition: background-color 0.15s;
    }
    .settings-nav-item:hover { background: hsl(var(--secondary)); }
    .settings-nav-item .material-symbols-outlined { color: hsl(var(--muted-foreground)); }
    .settings-nav-item.active { background: hsl(var(--secondary)); }
    .settings-nav-item.active .material-symbols-outlined { color: hsl(var(--primary)); }

    .settings-group-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        background: hsl(var(--secondary));
        color: hsl(var(--secondary-foreground));
    }

    .admin-input-group-suffix {
        border-left: none;
        border-right: 1px solid var(--input);
        border-radius: 0 var(--radius) var(--radius) 0;
        font-family: inherit;
        cursor: pointer;
    }
    .dark .admin-input-group-suffix { border-right-color: var(--input); }

    .settings-form [data-settings-group][hidden] { display: none; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('[data-settings-form]');
        if (!form) return;

        const navItems = Array.from(form.querySelectorAll('[data-settings-nav]'));
        const sections = Array.from(form.querySelectorAll('[data-settings-group]'));
        const currencySymbol = form.querySelector('[name="currency_symbol"]');
        const currencyDecimals = form.querySelector('[name="currency_decimals"]');
        const whatsappNumber = form.querySelector('[name="whatsapp_number"]');
        const whatsappMessage = form.querySelector('[name="whatsapp_default_message"]');
        const socialPreview = form.querySelector('[data-social-preview]');

        function activateGroup(key) {
            navItems.forEach(function (item) {
                item.classList.toggle('active', item.dataset.settingsNav === key);
            });

            sections.forEach(function (section) {
                section.hidden = key !== 'all' && section.dataset.settingsGroup !== key;
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        navItems.forEach(function (item) {
            item.addEventListener('click', function () {
                activateGroup(item.dataset.settingsNav);
            });
        });

        form.querySelectorAll('[data-secret-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = button.parentElement.querySelector('[data-secret-input]');
                if (!input) return;

                const revealed = input.type === 'text';
                input.type = revealed ? 'password' : 'text';
                button.querySelector('.material-symbols-outlined').textContent = revealed ? 'visibility' : 'visibility_off';
            });
        });

        function updateCurrencyPreview() {
            const symbol = (currencySymbol && currencySymbol.value.trim()) || '$';
            const decimals = parseInt(currencyDecimals && currencyDecimals.value, 10);
            const safeDecimals = Number.isNaN(decimals) ? 2 : decimals;

            form.querySelectorAll('[data-currency-preview]').forEach(function (node) {
                const amount = parseInt(node.dataset.currencyPreview, 10);
                node.textContent = symbol + new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: safeDecimals,
                    maximumFractionDigits: safeDecimals
                }).format(amount);
            });
        }

        function updateWhatsappPreview() {
            const node = form.querySelector('[data-whatsapp-preview]');
            if (!node) return;

            const number = (whatsappNumber && whatsappNumber.value.replace(/\D/g, '')) || '';
            const message = (whatsappMessage && whatsappMessage.value.trim()) || '';

            node.textContent = number
                ? 'https://wa.me/' + number + (message ? '?text=' + encodeURIComponent(message) : '')
                : 'Isi nomor WhatsApp untuk melihat tautan';
            node.classList.toggle('text-[hsl(var(--muted-foreground))]', number === '');
        }

        function updateSocialPreview() {
            if (!socialPreview) return;

            socialPreview.innerHTML = '';

            form.querySelectorAll('[name^="social_"]').forEach(function (input) {
                if (!input.value.trim()) return;

                const chip = document.createElement('span');
                chip.className = 'inline-flex items-center gap-1.5 rounded-full border border-[hsl(var(--border))] bg-[hsl(var(--card))] px-2.5 py-1 text-xs';
                chip.innerHTML = '<span class="material-symbols-outlined text-sm">' + (input.dataset.fieldIcon || 'link') + '</span>';
                chip.appendChild(document.createTextNode(input.name.replace('social_', '')));
                socialPreview.appendChild(chip);
            });

            if (!socialPreview.children.length) {
                const empty = document.createElement('span');
                empty.className = 'text-xs text-[hsl(var(--muted-foreground))]';
                empty.textContent = 'Belum ada tautan media sosial yang diisi.';
                socialPreview.appendChild(empty);
            }
        }

        const dirtyIndicator = form.querySelector('[data-dirty-indicator]');
        let dirty = false;

        function setDirty(state) {
            dirty = state;
            if (!dirtyIndicator) return;

            const icon = dirtyIndicator.querySelector('.material-symbols-outlined');
            const label = dirtyIndicator.querySelector('span:last-child');

            icon.textContent = state ? 'edit_note' : 'cloud_done';
            label.textContent = state
                ? 'Ada perubahan yang belum disimpan'
                : 'Semua perubahan tersimpan';
        }

        function refresh() {
            updateCurrencyPreview();
            updateWhatsappPreview();
            updateSocialPreview();
        }

        form.addEventListener('input', function (event) {
            refresh();
            if (event.target.matches('input, select, textarea')) setDirty(true);
        });

        form.addEventListener('change', function (event) {
            refresh();
            if (event.target.matches('input, select, textarea')) setDirty(true);
        });

        form.addEventListener('submit', function () {
            setDirty(false);
        });

        window.addEventListener('beforeunload', function (event) {
            if (!dirty) return;
            event.preventDefault();
            event.returnValue = '';
        });

        refresh();
        setDirty(false);
    });
</script>
@endpush

@endsection