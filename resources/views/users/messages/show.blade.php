@extends('layouts.app')

@section('title', $otherUser->name)

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="dm-card">
                <div class="dm-card-header">
                    <a href="{{ route('profile.show', $otherUser->id) }}"
                        class="d-flex align-items-center gap-3 text-decoration-none">
                        @if ($otherUser->avatar)
                            <img src="{{ $otherUser->avatar }}" alt="{{ $otherUser->name }}"
                                class="rounded-circle dm-avatar">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary dm-avatar-icon"></i>
                        @endif

                        <span class="fw-bold dm-user-name">{{ $otherUser->name }}</span>
                    </a>
                </div>

                <div class="dm-messages">
                    @forelse ($messages as $message)
                        @php
                            $isMine = $message->sender_id === Auth::id();
                        @endphp

                        <div class="dm-message-row {{ $isMine ? 'dm-message-mine' : 'dm-message-other' }}">
                            <div class="dm-message-content">
                                <div class="dm-bubble">{{ $message->body }}</div>

                                <div class="dm-message-info">
                                    <small>{{ $message->created_at->format('M j, H:i') }}</small>

                                    @if ($isMine && $message->read_at)
                                        <small>Seen</small>
                                    @endif

                                    @if ($isMine)
                                        <form action="{{ route('messages.destroy', $message) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-link btn-sm text-danger text-decoration-none p-0"
                                                onclick="return confirm('Delete this message?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-secondary py-5">
                            <p class="mb-0">Send your first message!</p>
                        </div>
                    @endforelse
                </div>

                <div class="dm-form-area">
                    <form action="{{ route('messages.store', $conversation) }}" method="post"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="text" name="body"
                            class="form-control dm-input @error('body') is-invalid @enderror"
                            value="{{ old('body') }}" placeholder="Write a message..." maxlength="1000"
                            autocomplete="off" autofocus>

                        <button type="submit" class="btn dm-send-button" aria-label="Send message">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>

                    @error('body')
                        <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@endsection
