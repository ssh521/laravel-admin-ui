@props([
    'headers' => [],
    'empty' => 'No records found.',
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-neutral-200 bg-white']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200 text-sm">
            @if (! empty($headers))
                <thead class="bg-neutral-50">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-4 py-3 text-left font-semibold text-neutral-700">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-neutral-200 bg-white text-neutral-800">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
