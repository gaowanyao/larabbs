@extends('layouts.app')
{{--直接读取 $user 对象的属性：--}}
@section('title', $user->name . ' 的个人中心')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
                            <img class="thumbnail img-responsive" src="{{ $user->avatar }}" onerror="this.src='https://fsdhubcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600'" width="300px" height="300px">
                        </div>
                        <div class="media-body">
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>
                                {{ $user->introduction }}
                            </p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>
                                {{--January 01 1901--}}
                                {{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </span>
                </div>
            </div>
            <hr>

            {{-- 用户发布的内容 --}}
            <div class="panel panel-default">
                <div class="panel-body">
                    {{--暂无数据 ~_~--}}

                    <ul class="nav nav-tabs">
                        <li class="{{ active_class(if_query('tab',null)) }}">
                            <a href="{{ route('users.show',$user->id) }}">Ta 的话题</a>
                        </li>
                        <li class="{{ active_class(if_query('tab','replies')) }}">
                            <a href="{{ route('users.show',[$user->id,'tab'=>'replies'])  }}">Ta 的回复</a>
                        </li>
                    </ul>

                    @if (if_query('tab','replies'))
                        @include('users._replies',['replies'=>$user->replies()->with('topic')->recent()->paginate(5)])
                    @else
                        @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                        {{--@include('users._topics',['topics'=>$topics])--}}
                    @endif

                </div>
            </div>

        </div>
    </div>
@stop