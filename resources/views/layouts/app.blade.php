<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
{{--app()->getLocale() 获取的是 config/app.php 中的 locale 选项--}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--csrf-token 标签是为了方便前端的 JavaScript 脚本获取 CSRF 令牌。--}}

    <title>@yield('title', 'GCAN') </title>
    {{--继承此模板的页面，如果没有定制 title 区域的话，就会自动使用第二个参数 GCAN 作为标题前缀。--}}

    {{--<meta name="description" content="@yield('description','GCAN 开发者社区')"/>--}}

    <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'GCAN') }}</title>
    <meta name="description" content="@yield('description', setting('seo_description', 'GCAN'))" />
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'GCAN,社区,论坛,开发者论坛'))" />


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?cc={{ rand(1,99999) }}" rel="stylesheet">
    {{--使用当前请求的协议（ HTTP 或 HTTPS ）为资源文件生成一个 URL--}}
    {{--生成 http://larabbs.gcan.top/css/app.css --}}

    {{--Simditor 的样式和脚本文件只需要在帖子创建页面中使用，出于性能考虑，我们将只在话题创建页码中加载这些文件。--}}
    {{--首先我们需要在主要布局文件中种下锚点 styles 和 scripts：--}}
    @yield('styles')

</head>

<body>
<div id="app" class="{{ route_class() }}-page">
    {{--route_class() 是我们自定义的辅助方法，我们还需要在 helpers.php 文件中添加此方法：--}}
    {{--此方法会将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制。--}}

    @include('layouts._header')
    {{--加载顶部导航区块的子模板。--}}

    <div class="container">

        @include('layouts._message')
        @yield('content')
        {{--占位符声明，允许继承此模板的页面注入内容。--}}

    </div>

    @include('layouts._footer')
    {{--加载页面尾部导航区块的子模板。页面的『顶部导航』和『尾部导航』子模板并不存在，接下来由我们来创建这两个模板。--}}
</div>

{{--更换用户--}}
@if (app()->isLocal())
    @include('sudosu::user-selector')
@endif

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>