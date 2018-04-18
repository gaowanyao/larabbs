@extends('layouts.app')

@section('title','话题列表')

@section('content')
<div class="row">
    <div class="col-md-9 col-lg-9 topic-list">
        <div class="panel panel-default">

            <div class="panel-heading">
                {{--<h1>--}}
                    {{--<i class="glyphicon glyphicon-align-justify"></i> Topic--}}
                    {{--<a class="btn btn-success pull-right" href="{{ route('topics.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>--}}
                {{--</h1>--}}

                <ul class="nav nav-pills">
                    <li role="presentation" class="active"><a href="#">最后回复</a></li>
                    <li role="presentation" class=""><a href="#">最新发布</a></li>
                </ul>

            </div>

            <div class="panel-body">

                {{--话题列表--}}
                @include('topics._topic_list',['topics'=>$topics])
                {{--分页--}}
                {!! $topics->render() !!}


                {{--@if($topics->count())--}}
                    {{--<table class="table table-condensed table-striped">--}}
                        {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th class="text-center">#</th>--}}
                                {{--<th>Title</th> <th>Body</th> <th>User_id</th> <th>Category_id</th> <th>Reply_count</th> <th>View_count</th> <th>Last_reply_user_id</th> <th>Order</th> <th>Excerpt</th> <th>Slug</th>--}}
                                {{--<th class="text-right">OPTIONS</th>--}}
                            {{--</tr>--}}
                        {{--</thead>--}}

                        {{--<tbody>--}}
                            {{--@foreach($topics as $topic)--}}
                                {{--<tr>--}}
                                    {{--<td class="text-center"><strong>{{$topic->id}}</strong></td>--}}

                                    {{--<td>{{$topic->title}}</td> <td>{{$topic->body}}</td> <td>{{$topic->user_id}}</td> <td>{{$topic->category_id}}</td> <td>{{$topic->reply_count}}</td> <td>{{$topic->view_count}}</td> <td>{{$topic->last_reply_user_id}}</td> <td>{{$topic->order}}</td> <td>{{$topic->excerpt}}</td> <td>{{$topic->slug}}</td>--}}
                                    {{----}}
                                    {{--<td class="text-right">--}}
                                        {{--<a class="btn btn-xs btn-primary" href="{{ route('topics.show', $topic->id) }}">--}}
                                            {{--<i class="glyphicon glyphicon-eye-open"></i> --}}
                                        {{--</a>--}}
                                        {{----}}
                                        {{--<a class="btn btn-xs btn-warning" href="{{ route('topics.edit', $topic->id) }}">--}}
                                            {{--<i class="glyphicon glyphicon-edit"></i> --}}
                                        {{--</a>--}}

                                        {{--<form action="{{ route('topics.destroy', $topic->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">--}}
                                            {{--{{csrf_field()}}--}}
                                            {{--<input type="hidden" name="_method" value="DELETE">--}}

                                            {{--<button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>--}}
                                        {{--</form>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    {{--{!! $topics->render() !!}--}}
                {{--@else--}}
                    {{--<h3 class="text-center alert alert-info">Empty!</h3>--}}
                {{--@endif--}}
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 sidebar">
        @include('topics._sidebar')
    </div>

</div>

@endsection