<label class="text-sm text-gray-400 mb-2 flex items-center gap-2 {{ $class ?? '' }}"
    @if (isset($for))
        for="{{ $for }}"
    @endif>
    @if (isset($icon))
        <i class="fas fa-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</label>
