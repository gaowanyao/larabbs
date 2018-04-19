@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('editor/css/simditor.css') }}"/>
@stop
@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Topic /
                    @if($topic->id)
                        Edit #{{$topic->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($topic->id)
                    <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                    <div class="form-group">
                        <label for="title-field">标题</label>
                        <input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title ) }}" placeholder="请输入标题" />
                    </div>

                    <div class="form-group">
                        <label for="category_id-field">分类</label>
                        {{--<input class="form-control" type="text" name="category_id" id="category_id-field" value="{{ old('category_id', $topic->category_id ) }}" />--}}
                        <select class="form-control" name="category_id" required>
                            <option value="" hidden disabled selected>请选择分类</option>
                            @foreach($categories as $value)
                                <option value="{{ $value->id }}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="body-field">内容</label>
                        <textarea name="body" id="editor" class="form-control" rows="3" placeholder="请输入至少三个字符的内容。">{{ old('body', $topic->body ) }}</textarea>
                    </div>



                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保存</button>
                        <a class="btn btn-link pull-right" href="{{ route('topics.index') }}"><i class="glyphicon glyphicon-backward"></i>  返回</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('editor/js/module.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('editor/js/hotkeys.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('editor/js/uploader.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('editor/js/simditor.js') }}"> </script>
    <script>
        $(document).ready(function () {
           var editor = new Simditor({
               textarea:$("#editor"),
           })
        });
    </script>
@stop