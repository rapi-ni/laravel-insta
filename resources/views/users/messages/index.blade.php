@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
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

        <div class="col-lg-4">
            <div class="dm-card dm-new-chat-card">
                <div class="dm-card-header">
                    <h2 class="h6 fw-bold mb-1">
                        <i class="fa-solid fa-pen-to-square me-2" aria-hidden="true"></i>
                        New message
                    </h2>
                    <small class="text-secondary">Select someone you follow</small>
                </div>

                <div class="dm-messageable-list">
                    @forelse ($messageableUsers as $user)
                        <form action="{{ route('messages.start', $user) }}" method="post"
                            class="dm-messageable-user">
                            @csrf

                            <button type="submit" class="dm-messageable-button">
                                <span class="flex-shrink-0">
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                            class="rounded-circle dm-avatar">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary dm-avatar-icon"
                                            aria-hidden="true"></i>
                                    @endif
                                </span>

                                <span class="fw-bold text-truncate">{{ $user->name }}</span>
                                <i class="fa-regular fa-paper-plane ms-auto" aria-hidden="true"></i>
                            </button>
                        </form>
                    @empty
                        <div class="text-center text-secondary p-4">
                            <i class="fa-solid fa-user-plus fs-3 mb-2" aria-hidden="true"></i>
                            <p class="small mb-0">Follow someone to start a conversation.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
