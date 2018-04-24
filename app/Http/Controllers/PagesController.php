<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//我们将使用控制器 PagesController 来处理所有自定义页面的逻辑，并使用 root() 方法来处理首页的展示。接下来执行以下命令新建控制器：
//$ php artisan make:controller PagesController


class PagesController extends Controller
{
    //

    public function root()
    {
        return view('pages.root');
    }

    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('pages.permission_denied');
    }

}
