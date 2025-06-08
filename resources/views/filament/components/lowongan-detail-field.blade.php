<div class="flex items-center space-x-2">
    @if(isset($icon))
        <x-dynamic-component
            :component="$icon"
            class="w-5 h-5 text-gray-500"
        />
    @endif
    <div class="font-medium text-gray-900 dark:text-white">
        {{ $getState() }}
    </div>
</div>