@php
    $type = $field['type'] ?? 'text';
    $inputId = 'setting-'.$key;
    $current = old($key, $value);
    $isWide = in_array($type, ['textarea'], true);
    $hasError = $errors->has($key);
    $isReadonly = ! empty($field['readonly']);
@endphp

<div class="{{ $isWide ? 'md:col-span-2' : '' }}">
    <div class="flex flex-wrap items-center justify-between gap-x-3 gap-y-1 mb-1.5">
        <label for="{{ $inputId }}" class="admin-form-label !mb-0">{{ $field['label'] }}</label>

        @if (! empty($field['required']))
            <span class="admin-badge admin-badge-danger !text-[10px] !py-0.5 !px-2">Wajib</span>
        @elseif ($isReadonly)
            <span class="admin-badge admin-badge-info !text-[10px] !py-0.5 !px-2">Hanya Baca</span>
        @else
            <span class="text-[10px] font-medium uppercase tracking-wide text-[hsl(var(--muted-foreground))]">Opsional</span>
        @endif
    </div>

    @if ($isReadonly)
        <div class="admin-form-input bg-[hsl(var(--muted))] cursor-not-allowed min-h-[38px] flex items-center" id="{{ $inputId }}">
            @if ($current !== '')
                {{ $current }}
            @else
                <span class="text-[hsl(var(--muted-foreground))]">—</span>
            @endif
        </div>
    @elseif ($type === 'textarea')
        <textarea
            id="{{ $inputId }}"
            name="{{ $key }}"
            rows="{{ $field['rows'] ?? 3 }}"
            placeholder="{{ $field['placeholder'] ?? '' }}"
            class="admin-form-input resize-y @if ($hasError) !border-red-500 dark:!border-red-500 @endif"
            @if (! empty($field['sensitive'])) autocomplete="off" @endif
        >{{ $current }}</textarea>

    @elseif ($type === 'select')
        <select
            id="{{ $inputId }}"
            name="{{ $key }}"
            class="admin-form-input"
        >
            @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $current === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>

    @elseif ($type === 'password')
        <div class="admin-input-group">
            <input
                id="{{ $inputId }}"
                name="{{ $key }}"
                type="password"
                value="{{ $current }}"
                placeholder="{{ $field['placeholder'] ?? '' }}"
                autocomplete="new-password"
                class="admin-form-input font-mono text-xs @if ($hasError) !border-red-500 dark:!border-red-500 @endif"
                data-secret-input
            >
            <button
                type="button"
                class="admin-input-group-text admin-input-group-suffix hover:opacity-70"
                aria-label="Tampilkan atau sembunyikan nilai"
                data-secret-toggle
            >
                <span class="material-symbols-outlined text-lg">visibility</span>
            </button>
        </div>

    @elseif ($type === 'number')
        <div class="admin-input-group">
            <input
                id="{{ $inputId }}"
                name="{{ $key }}"
                type="number"
                min="{{ $field['min'] ?? 0 }}"
                value="{{ $current }}"
                placeholder="{{ $field['placeholder'] ?? '' }}"
                class="admin-form-input @if ($hasError) !border-red-500 dark:!border-red-500 @endif"
            >
            @if (! empty($field['unit']))
                <span class="admin-input-group-text admin-input-group-suffix min-w-[56px] text-xs">{{ $field['unit'] }}</span>
            @endif
        </div>

    @else
        @php $inputType = in_array($type, ['url', 'email', 'tel', 'number'], true) ? $type : 'text'; @endphp
        <input
            id="{{ $inputId }}"
            name="{{ $key }}"
            type="{{ $inputType }}"
            value="{{ $current }}"
            placeholder="{{ $field['placeholder'] ?? '' }}"
            @if (! empty($field['icon'])) data-field-icon="{{ $field['icon'] }}" @endif
            class="admin-form-input @if ($hasError) !border-red-500 dark:!border-red-500 @endif"
        >
    @endif

    @if (! empty($field['hint']))
        <p class="mt-1.5 text-xs leading-relaxed text-[hsl(var(--muted-foreground))]">{{ $field['hint'] }}</p>
    @endif

    @error($key)
        <p class="mt-1.5 flex items-center gap-1 text-xs text-red-500 dark:text-red-400">
            <span class="material-symbols-outlined text-sm">error</span>
            {{ $message }}
        </p>
    @enderror
</div>