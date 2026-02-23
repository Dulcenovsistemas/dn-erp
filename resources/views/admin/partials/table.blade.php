<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-6 py-4 text-left font-semibold text-gray-600">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="divide-y">
            @yield('table-rows')
        </tbody>
    </table>
</div>
