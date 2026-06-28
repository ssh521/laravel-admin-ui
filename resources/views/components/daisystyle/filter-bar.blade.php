<form {{ $attributes->merge(['method' => 'GET', 'class' => 'mt-6 flex flex-col gap-3 rounded-box border border-base-300 bg-base-200 p-4 sm:flex-row sm:items-center']) }}>
    {{ $slot }}
</form>
