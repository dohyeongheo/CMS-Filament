<x-notifications::notification :notification="$notification" class="flex w-80 rounded-lg transition duration-200"
    x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0">
    <h4>
        {{ $getTitle() }}
    </h4>

    <p>
        {{ $getDate() }}
    </p>

    <p>
        {{ $getBody() }}
    </p>

    <span x-on:click="close">
        Close
    </span>
</x-notifications::notification>
