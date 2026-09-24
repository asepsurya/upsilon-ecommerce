<div class="image-preview {{ $image->is_primary ? 'primary' : '' }}" data-image-id="{{ $image->id }}">
    <img src="{{ asset($image->image) }}" alt="Product image" loading="lazy">
    @if($image->is_primary)
        <span class="material-symbols-outlined" style="position: absolute; top: 4px; left: 4px; font-size: 14px; color: #000;">star</span>
    @endif
    <button type="button" class="remove-btn" title="Delete image" data-image-id="{{ $image->id }}">
        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
    </button>
</div>
