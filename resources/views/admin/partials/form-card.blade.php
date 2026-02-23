<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ $title }}
        </h2>

        @isset($description)
            <p class="text-sm text-gray-500 mt-1">
                {{ $description }}
            </p>
        @endisset
    </div>

    {{ $slot ?? '' }}
</div>
