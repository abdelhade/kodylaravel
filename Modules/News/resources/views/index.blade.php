@extends('dashboard.layout')

@section('content')
<style>
    .card {
        position: relative;
    }
    .news_cover {
        width: 100%;
        height: 100%;
        opacity: 0.5;
        transition: 1s;
    }
    .title {
        position: absolute;
        background-color: white;
        margin-left: 20px;
        top: 80%;
        width: 90%;
        opacity: .4;
        border: 1px solid white;
        transition: 0.5s;
    }
    .news_cover:hover {
        width: 103%;
        opacity: 0.7;
    }
    .title:hover {
        position: absolute;
        background-color: white;
        opacity: .9;
        border: 4px solid white;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('news.create') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        {{ $lang['lang_add_new'] ?? 'إضافة جديد' }}
                    </a>
                </div>
                <div class="row">
                    @forelse($news as $newsItem)
                        <div class="col-lg-3">
                            <a href="{{ route('news.show', ['id' => $newsItem->id]) }}">
                                <div class="card-body">
                                    <img src="{{ asset('uploads/' . ($newsItem->img ?? '')) }}" 
                                         title="{{ $newsItem->content }}" 
                                         class="news_cover" 
                                         onerror="this.src='{{ asset('assets/favicon/favicon.png') }}';">
                                </div>
                                <center>
                                    <h3 class="title">{{ $newsItem->title }}</h3>
                                </center>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                لا توجد أخبار
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
