@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('editor/css/simditor.css') }}"/>
@stop
@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    {{--Topic /--}}
                    @if($topic->id)
                        编辑话题
                    @else
                        新建话题
                    @endif
                </h2>
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
        // http://simditor.tower.im/docs/doc-config.html#anchor-upload
        $(document).ready(function () {
           var editor = new Simditor({
               textarea:$("#editor"),
               upload:{
                   url:'{{ route('topics.upload_image') }}',
                   params:{ _token:'{{ csrf_token() }}'},
                   fileKey:'upload_file',
                   connectionCount:3,
                   leaceConfirm:'文件上传中，关闭此页面将取消上传。'
               },
               pasteImage:true,
           })
        });

        // pasteImage —— 设定是否支持图片黏贴上传，这里我们使用 true 进行开启；
// url —— 处理上传图片的 URL；
// params —— 表单提交的参数，Laravel 的 POST 请求必须带防止 CSRF 跨站请求伪造的 _token 参数；
// fileKey —— 是服务器端获取图片的键值，我们设置为 upload_file;
//         connectionCount —— 最多只能同时上传 3 张图片；
// leaveConfirm —— 上传过程中，用户关闭页面时的提醒。
        
    </script>
@stop