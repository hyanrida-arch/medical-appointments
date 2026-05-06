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
        $user = Auth::user();

        $conversations = Conversation::where('patient_id', $user->id)
            ->orWhere('doctor_id', $user->id)
            ->with(['patient', 'doctor', 'latestMessage'])
            ->get()
            ->sortByDesc(function ($conv) {
                return $conv->latestMessage?->created_at ?? $conv->updated_at;
            });

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorizeConversation($conversation);

        $conversation->load(['patient', 'doctor', 'messages.sender']);

        // Mark all unread messages from the other user as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('conversation'));
    }

    public function startWith(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->isPatient() && $user->isDoctor()) {
            $conversation = Conversation::firstOrCreate([
                'patient_id' => $authUser->id,
                'doctor_id' => $user->id,
            ]);
        } elseif ($authUser->isDoctor() && $user->isPatient()) {
            $conversation = Conversation::firstOrCreate([
                'patient_id' => $user->id,
                'doctor_id' => $authUser->id,
            ]);
        } else {
            abort(403);
        }

        return redirect()->route('messages.show', $conversation);
    }

    public function store(Request $request, Conversation $conversation)
    {
        $this->authorizeConversation($conversation);

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'body' => $request->body,
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation);
    }

    public function destroy(Conversation $conversation)
    {
        $this->authorizeConversation($conversation);

        // Delete all messages first, then the conversation
        $conversation->messages()->delete();
        $conversation->delete();

        return redirect()->route('messages.index')
            ->with('success', __('messages.conversation_deleted'));
    }

    private function authorizeConversation(Conversation $conversation): void
    {
        $userId = Auth::id();
        if ($conversation->patient_id !== $userId && $conversation->doctor_id !== $userId) {
            abort(403);
        }
    }
}