@forelse($posts as $post)
    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
        <img src="{{ $post->image }}" width="200" />
    </div>
@empty
    <p>Belum ada data.</p>
@endforelse