@php
    $ratings = [
        ['key' => 'rating_taste', 'label' => 'Taste', 'icon' => 'fa-bowl-food'],
        ['key' => 'rating_volume', 'label' => 'Volume', 'icon' => 'fa-layer-group'],
        ['key' => 'rating_sulit', 'label' => 'Value', 'icon' => 'fa-tag'],
        ['key' => 'rating_vibes', 'label' => 'Vibes', 'icon' => 'fa-music'],
    ];
@endphp

@if(collect($ratings)->contains(fn ($rating) => (bool) $post->{$rating['key']}))
    <section class="post-ratings" aria-label="Food ratings">
        <div class="post-ratings-title"><span>My rating</span></div>
        <div class="post-ratings-grid">
            @foreach($ratings as $rating)
                @php($value = $post->{$rating['key']})
                @if($value)
                    <div class="post-rating-item">
                        <span class="post-rating-label"><i class="fa-solid {{ $rating['icon'] }}"></i>{{ $rating['label'] }}</span>
                        <span class="post-rating-score">{{ number_format($value, 1) }}</span>
                        <div class="post-rating-stars" aria-label="{{ number_format($value, 1) }} out of 5">
                            @for ($i = 1; $i <= floor($value); $i++)<i class="fa-solid fa-star"></i>@endfor
                            @if (fmod($value, 1) != 0)<i class="fa-solid fa-star-half-stroke"></i>@endif
                            @for ($i = 1; $i <= (5 - ceil($value)); $i++)<i class="fa-regular fa-star"></i>@endfor
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endif
