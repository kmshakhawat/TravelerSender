<div>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chat') }}
            </h2>
            <a class="btn-secondary" href="{{ route('dashboard') }}">Back</a>
        </div>
    </x-slot>
    <div class="container py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!$receiver)
                <x-no-data />
            @endif
            <div class="flex flex-col sm:flex-row gap-5 justify-between">
                <div class="w-full sm:w-1/4 max-h-[300px] sm:max-h-[500px] overflow-y-auto">
                    @foreach ($users ?? collect() as $user)
                        <div wire:click="selectUser({{ $user->id }})" class="cursor-pointer mb-1 p-2 border-b flex gap-2 items-center rounded
                        {{ isset($receiver) && $receiver->id === $user->id ? 'bg-primary text-white' : '' }}">
                            <img class="size-10 rounded-full object-cover" src="{{ $user->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $user->name }}" />
                            <div>
                                {{ $user->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($receiver)
                    <div class="p-4 bg-white shadow-md rounded w-full sm:w-3/4">
                        <h2 class="text-lg font-semibold mb-4 flex justify-between items-center">
                            Message with {{ $receiver->name }}
                        </h2>
                        <div id="messages-container" class="border p-3 overflow-y-auto h-80 sm:max-h-[500px]">
                            @foreach($messages->groupBy(function($msg) {
                                return $msg->created_at->format('Y-m-d');
                            }) as $date => $msgs)
                                <div class="text-center text-gray-500 mb-2">
                                    @php
                                        $carbonDate = \Carbon\Carbon::parse($date);
                                        if ($carbonDate->isToday()) {
                                            echo 'Today';
                                        } elseif ($carbonDate->isYesterday()) {
                                            echo 'Yesterday';
                                        } else {
                                            echo $carbonDate->format('d M Y'); // Example: "15 Mar 2025"
                                        }
                                    @endphp
                                </div>

                                @foreach ($msgs as $msg)
                                    <div class="mb-2 group chat-text {{ $msg->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                        <span title="{{ $msg->created_at->setTimezone(config('app.timezone'))->format('h:i A T') }}" class="inline-block px-4 py-2 rounded-lg
                                            {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-secondary text-white' }}">
                                            {{ $msg->content }}
                                        </span>
                                        <div class="text-gray-500 text-xs opacity-0 ml-2 group-hover:opacity-100">
                                            {{ $msg->created_at->setTimezone(config('app.timezone'))->format('h:i A T') }}
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <form wire:submit.prevent="sendMessage">
                                <input type="text" wire:model="messageContent" class="w-full px-3 py-2 border rounded" placeholder="Type a message...">
                                <div class="flex justify-between items-center">
                                    <button type="submit" class="mt-2 px-4 py-2 bg-primary text-white rounded">Send</button>

                                    <button wire:click="refreshMessages" class="flex gap-1 items-center px-2 text-xs rounded bg-[#F56565] text-white hover:bg-[#FF7070]">
                                        <svg data-v-c9f5a6e8="" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4">
                                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                            <path d="M8 16H3v5"></path>
                                        </svg>
                                        Refresh
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('replaceState', url => {
            window.history.replaceState({}, '', url);
        });
    });
    // Make sure this runs both on initial load and after updates
    document.addEventListener('livewire:initialized', () => {
        const scrollToBottom = () => {
            const messageContainer = document.getElementById('messages-container');
            setTimeout(() => {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }, 50); // Small delay to ensure DOM is updated
        };

        // Scroll on initial load
        scrollToBottom();

        // Scroll when new messages are sent
        Livewire.on('messageSent', () => {
            const messageContainer = document.getElementById('messages-container');
            document.querySelector('input[wire\\:model="messageContent"]').value = '';

            scrollToBottom();
        });
    });
</script>
