@extends('dashboard.layout')

@section('content')
<style>
    .news_cover {
        width: 25%;
        height: 100%;
        opacity: 0.5;
        transition: 1s;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .news_cover:hover {
        width: 30%;
        opacity: 1;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if(session('error'))
                <div class="alert alert-danger">
                    <h3>{{ session('error') }}</h3>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $newsItem->title }}</h2>
                    </div>
                    <div class="card-body">
                        @if($newsItem->img)
                            <img class="news_cover" 
                                 src="{{ asset('uploads/' . $newsItem->img) }}" 
                                 alt="{{ $newsItem->title }}" 
                                 onerror="this.src='{{ asset('assets/favicon/favicon.png') }}';">
                        @endif

                        <h4>{!! $newsItem->content !!}</h4>
                        @if($newsItem->tags)
                            <p><strong>Tags:</strong> {{ $newsItem->tags }}</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('news.index') }}" class="btn btn-secondary">رجوع</a>
                        <form action="{{ route('news.destroy', ['id' => $newsItem->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد بالتأكيد حذف هذا الخبر؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
