<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with([
                'userOne',
                'userTwo',
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                },
            ])
            ->where(function ($query) {
                $query->where('user_one_id', Auth::id())
                    ->orWhere('user_two_id', Auth::id());
            })
            ->latest('updated_at')
            ->get();

        return view('users.messages.index', compact('conversations'));
    }

    public function start(User $user)
    {
        abort_if($user->id === Auth::id(), 403);

        $userOneId = min(Auth::id(), $user->id);
        $userTwoId = max(Auth::id(), $user->id);

        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $userOneId,
            'user_two_id' => $userTwoId,
        ]);

        return redirect()->route('messages.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        abort_unless($conversation->hasParticipant(Auth::id()), 403);

        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->values();

        $otherUser = $conversation->otherUser(Auth::id());

        return view('users.messages.show', compact(
            'conversation',
            'messages',
            'otherUser'
        ));
    }

    public function store(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->hasParticipant(Auth::id()), 403);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation);
    }

    public function destroy(Message $message)
    {
        abort_unless(
            $message->sender_id === Auth::id()
            && $message->conversation->hasParticipant(Auth::id()),
            403
        );

        $conversation = $message->conversation;
        $message->delete();
        $conversation->touch();

        return redirect()->back();
    }
}
