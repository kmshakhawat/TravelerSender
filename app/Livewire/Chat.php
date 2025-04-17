<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $users = [];
    public $receiver;
    public $messages;
    public $messageContent;

    protected $listeners = ['messageSent' => 'refreshMessages'];

    public function mount($receiverId = null)
    {
        if ($receiverId) {
            if (auth()->id() == $receiverId) {
                return redirect()->route('dashboard')->with('error', 'You cannot send message to yourself.');
            }
            $this->receiver = User::find($receiverId);
        } else {
            $lastChat = Message::where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->latest('created_at')
                ->first();

            if ($lastChat) {
                $this->receiver = $lastChat->sender_id == auth()->id() ? User::find($lastChat->receiver_id) : User::find($lastChat->sender_id);
            }
        }

        $this->messages = $this->receiver ? $this->loadMessages() : collect();

        $this->users = User::whereIn('id', function ($query) {
            $query->select('sender_id')
                ->from('messages')
                ->where('receiver_id', auth()->id())
                ->union(
                    User::select('receiver_id')
                        ->from('messages')
                        ->where('sender_id', auth()->id())
                );
        })
            ->withCount(['unreadMessages' => function ($query) {
                $query->where('receiver_id', auth()->id())->whereNull('read_at');
            }])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('sender_id', 'users.id')
                    ->orWhereColumn('receiver_id', 'users.id')
                    ->latest()
                    ->take(1)
            )
            ->get();
    }

    public function selectUser($userId)
    {
        $this->receiver = User::find($userId);
        $this->messages = $this->loadMessages();
        return redirect()->route('message', ['receiverId' => $userId]);
    }

    public function refreshMessages()
    {
        $this->messages = $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->receiver) {
            return collect();
        }

        $messages = Message::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $this->receiver->id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver->id)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        $unread = $messages->where('receiver_id', auth()->id())->whereNull('read_at');
        foreach ($unread as $msg) {
            $msg->update(['read_at' => now()]);
        }

        return $messages;

    }

    public function sendMessage()
    {
        if (!$this->receiver || empty($this->messageContent)) {
            return;
        }

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver->id,
            'content' => $this->messageContent,
        ]);

        $this->reset('messageContent');
        $this->messages = $this->loadMessages();

        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
