<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>

    <textarea
        name="{{ $name }}"
        rows="3"
        class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
    >{{ $value ?? '' }}</textarea>

    @error($name)
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
