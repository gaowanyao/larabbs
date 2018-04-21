@extends('layouts.app')
@section('title',$topic->title)
@section('description',$topic->excerpt)

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="text-center">
                        作者：{{ $topic->user->name }}
                    </div>
                    
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show',$topic->user->id) }}">
                                <img class="thumbnail img-responsive" src="{{ $topic->user->avatar }}" width="300" height="300">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
            <div class="panel panel-default">
                <div class="panel-body">

                    <h1 class="text-center">{{ $topic->title }}</h1>

                    <div class="article-meta text-center">
                        {{ $topic->created_at->diffForHumans() }}
                        .
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                        {{ $topic->reply_count }}
                    </div>

                    <div class="topic-body">
                        {!! $topic->body !!}
                    </div>

                    @can('update',$topic)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('topics.edit',$topic->id) }}" class="btn btn-default btn-xs" role="button">
                                <i class="glyphicon glyphicon-edit"></i> 编辑
                            </a>
                            <a onclick="document.getElementById('delete_my_topic').click();" class="btn btn-default btn-xs" role="button">
                                <i class="glyphicon glyphicon-trash"></i> 删除
                            </a>
                            <form action="{{route('topics.destroy',$topic->id)}}" method="post">

                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" id="delete_my_topic" class="btn btn-default btn-xs" style="margin-left: 6px;display: none;">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    删除
                                </button>
                            </form>

                        </div>

                     @endcan

                </div>
            </div>
            {{--用户回复列表--}}
            <div class="panel panel-default topic-reply">
                <div class="panel-body">
                    {{--注意读取回复列表时需使用懒加载来避免 N+1 问题。接下来说说我们新增的两个子模板：--}}
                    {{--_reply_box 回复框；--}}
                    {{--_reply_list 用户回复列表--}}
                    {{--@include('topics._reply_box',['topic'=>$topic])--}}
                    {{--话题回复功能我们只允许登录用户使用，未登录用户不显示即可。Laravel Blade 模板提供了一个『视条件加载子模板』的语法--}}
                    {{--@includeWhen($boolean, 'view.name', ['some' => 'data'])--}}
                    @includeWhen(Auth::check(),'topics._reply_box',['topic'=>$topic])

                    @include('topics._reply_list',['replies'=>$topic->replies()->with('user')->get()])
                </div>
            </div>

        </div>

    </div>

{{--<div style="display: none;" class="container">--}}
    {{--<div class="col-md-10 col-md-offset-1">--}}
        {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">--}}
                {{--<h1>Topic / Show #{{ $topic->id }}</h1>--}}
            {{--</div>--}}

            {{--<div class="panel-body">--}}
                {{--<div class="well well-sm">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-6">--}}
                            {{--<a class="btn btn-link" href="{{ route('topics.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                             {{--<a class="btn btn-sm btn-warning pull-right" href="{{ route('topics.edit', $topic->id) }}">--}}
                                {{--<i class="glyphicon glyphicon-edit"></i> Edit--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<label>Title</label>--}}
{{--<p>--}}
	{{--{{ $topic->title }}--}}
{{--</p> <label>Body</label>--}}
{{--<p>--}}
	{{--{{ $topic->body }}--}}
{{--</p> <label>User_id</label>--}}
{{--<p>--}}
	{{--{{ $topic->user_id }}--}}
{{--</p> <label>Category_id</label>--}}
{{--<p>--}}
	{{--{{ $topic->category_id }}--}}
{{--</p> <label>Reply_count</label>--}}
{{--<p>--}}
	{{--{{ $topic->reply_count }}--}}
{{--</p> <label>View_count</label>--}}
{{--<p>--}}
	{{--{{ $topic->view_count }}--}}
{{--</p> <label>Last_reply_user_id</label>--}}
{{--<p>--}}
	{{--{{ $topic->last_reply_user_id }}--}}
{{--</p> <label>Order</label>--}}
{{--<p>--}}
	{{--{{ $topic->order }}--}}
{{--</p> <label>Excerpt</label>--}}
{{--<p>--}}
	{{--{{ $topic->excerpt }}--}}
{{--</p> <label>Slug</label>--}}
{{--<p>--}}
	{{--{{ $topic->slug }}--}}
{{--</p>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

@endsection
