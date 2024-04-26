{{--@if (Auth::id() != $micropost->user_id)--}}
<div style="flex: 1.5;">
   @if (Auth::user()->is_favorite($micropost->id))
        {{-- お気に入り外すボタンのフォーム --}}
        <form method="POST" action="{{ route('favorites.unfavorite', $micropost->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-success btn-sm normal-case">Unfavorite</button>
        </form>
    @else
        {{-- お気に入りボタンのフォーム --}}
        <form method="POST" action="{{ route('favorites.favorite', $micropost->id) }}">
            @csrf
            <button type="submit" class="btn btn-sm normal-case">Favorite</button>
        </form>
    @endif
</div>
{{--@endif--}}