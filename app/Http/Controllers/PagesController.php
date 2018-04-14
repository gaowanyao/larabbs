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
}
