<div class="flex items-center gap-2">
    <input type="checkbox"
           name="{{ $name }}"
           value="1"
           {{ $checked ? 'checked' : '' }}
           class="rounded border-gray-300 text-gray-900">

    <label class="text-sm text-gray-700">
        {{ $label }}
    </label>
</div>
