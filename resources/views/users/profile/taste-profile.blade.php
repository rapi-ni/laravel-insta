@php
    $tasteItems = [
        ['label' => 'Spicy', 'emoji' => '🌶️', 'value' => (int) ($user->spicy_level ?? 0)],
        ['label' => 'Sweet', 'emoji' => '🧁', 'value' => (int) ($user->sweet_level ?? 0)],
        ['label' => 'Meat', 'emoji' => '🍖', 'value' => (int) ($user->meat_level ?? 0)],
        ['label' => 'Vegetables', 'emoji' => '🥦', 'value' => (int) ($user->vegetable_level ?? 0)],
    ];

    $favoriteFoods = collect(explode(',', $user->favorite_foods ?? ''))
        ->map(fn ($food) => trim($food))
        ->filter();
@endphp

<section class="taste-profile-card" aria-labelledby="taste-profile-title">
    <div class="taste-profile-heading">
        <h3 id="taste-profile-title" class="taste-profile-title">Taste Profile</h3>
        <p class="taste-profile-subtitle">My food mood</p>
    </div>

    <div class="taste-profile-scales">
        @foreach ($tasteItems as $item)
            <div class="taste-profile-row">
                <span class="taste-profile-label">{{ $item['label'] }}</span>

                <span class="taste-profile-icons" aria-label="{{ $item['label'] }}: {{ $item['value'] }} out of 5">
                    @for ($level = 1; $level <= 5; $level++)
                        <span class="taste-profile-emoji {{ $level <= $item['value'] ? 'is-active' : '' }}"
                            aria-hidden="true">
                            {{ $item['emoji'] }}
                        </span>
                    @endfor
                </span>

                <strong class="taste-profile-score">{{ $item['value'] }} / 5</strong>
            </div>
        @endforeach
    </div>

    <div class="taste-favorites">
        <span class="taste-favorites-label">Favorite Foods</span>

        <div class="taste-favorite-tags">
            @forelse ($favoriteFoods as $food)
                <span class="taste-favorite-tag">{{ $food }}</span>
            @empty
                <span class="taste-favorites-empty">Not added yet.</span>
            @endforelse
        </div>
    </div>
</section>
