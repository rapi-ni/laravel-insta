@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="dm-card">
                <div class="dm-card-header">
                    <h2 class="h5 fw-bold mb-0">Messages</h2>
                </div>

                <div class="dm-conversation-list">
                    @forelse ($conversations as $conversation)
                        @php
                            $otherUser = $conversation->otherUser(Auth::id());
                            $latestMessage = $conversation->latestMessage;
                        @endphp

                        <a href="{{ route('messages.show', $conversation) }}" class="dm-conversation-item">
                            <div class="flex-shrink-0">
                                @if ($otherUser->avatar)
                                    <img src="{{ $otherUser->avatar }}" alt="{{ $otherUser->name }}"
                                        class="rounded-circle dm-avatar">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary dm-avatar-icon"></i>
                                @endif
                            </div>

                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between gap-3">
                                    <span class="fw-bold text-truncate">{{ $otherUser->name }}</span>

                                    @if ($latestMessage)
                                        <small class="text-secondary flex-shrink-0">
                                            {{ $latestMessage->created_at->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>

                                <p class="text-secondary text-truncate mb-0">
                                    @if ($latestMessage)
                                        @if ($latestMessage->sender_id === Auth::id())
                                            You:
                                        @endif
                                        {{ $latestMessage->body }}
                                    @else
                                        Start a conversation.
                                    @endif
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="text-center text-secondary py-5">
                            <i class="fa-regular fa-paper-plane fs-1 mb-3"></i>
                            <p class="mb-0">No conversations yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
