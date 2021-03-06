@extends('layout.main')

@section('content')
    <div class="col-sm-8 blog-main">
        <form action="/posts/{{ $post->id }}" method="POST">
            {{-- <input type="hidden" name="_method" value="PUT"> --}}
            {{ method_field('PUT') }}
            {{-- <input type="hidden" name="_token" value="MESUY3topeHgvFqsy9EcM916UWQq6khiGHM91wHy"> --}}
            {{ csrf_field() }}
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" placeholder="这里是标题" value="{{ $post->title }}">
            </div>
            <div class="form-group">
                <label>内容</label>
                <textarea id="content" name="content" class="form-control" style="height:400px;max-height:500px;"
                    placeholder="这里是内容">{{ $post->content }}</textarea>
            </div>
            @include('layout.error')
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <br>
    </div><!-- /.blog-main -->
@endsection
