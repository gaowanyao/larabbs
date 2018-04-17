<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
//use Carbon\Carbon;

//引入了 App\Models\User 用户模型 show() 方法中使用到 User 模型 所以我们必须先引用

class UsersController extends Controller
{

//__construct 是 PHP 的构造器方法，当一个类对象被创建之前该方法将会被调用。我们在 __construct 方法中调用了 middleware 方法，该方法接收两个参数，第一个为中间件的名称，第二个为要进行过滤的动作。我们通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤，意为 —— 除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制。相反的还有 only 白名单方法，将只过滤指定动作。我们提倡在控制器 Auth 中间件使用中，首选 except 方法，这样的话，当你新增一个控制器方法时，默认是安全的，此为最佳实践。
//Laravel 提供的 Auth 中间件在过滤指定动作时，如该用户未通过身份验证（未登录用户），将会被重定向到登录页面：
    public function __construct()
    {
        $this->middleware('auth',['except'=>['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


//Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明。在上面代码中，由于 show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
//此功能称为 『隐性路由模型绑定』，是『约定优于配置』设计范式的体现，同时满足以下两种情况，此功能即会自动启用：
//1). 路由声明时必须使用 Eloquent 模型的单数小写格式来作为 路由片段参数，User 对应 {user}：
//我们将用户对象变量 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将变量数据传递到视图中。
//show 方法添加完成之后，在视图中，我们即可直接使用 $user 变量来获取 view 方法传递给视图的用户数据。
    public function show(User $user)
    {
//Carbon 是继承自 PHP DateTime 类 的子类，但比后者提供了更加丰富、更加语义化的 API。其中一个比较实用的 API 就是 diffForHumans 方法，几乎每个用 Laravel 构建的项目中都有用到它。
//比如，一个博客系统里的文章发布时间，显示格式可能就像下面这样：
//        **距离现在时间**      **显示格式**
//< 1小时               xx分钟前
//1小时 - 24小时        xx小时前
//1天 - 15天            xx天前
//    > 15天                直接显示日期
//        修改下面文件即可
//        app/Providers/AppServiceProvider.php
//        Carbon::setLocale('zh');

//        $user = User::find($id);
        return view("users.show",compact('user'));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
//        dd($user->name);
//        $user = User::find($id);
        return view("users.edit",compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

//        因为我们使用了命名空间，所以需要在顶部加载 use App\Handlers\ImageUploadHandler;；
//$data = $request->all(); 赋值 $data 变量，以便对更新数据的操作；
//以下代码处理了图片上传的逻辑，注意 if ($result) 的判断是因为 ImageUploadHandler 对文件后缀名做了限定，不允许的情况下将返回 false：
        $data = $request->all();
        if ($request->avatar){
            $result = $uploader->save($request->avatar,'avatars',$user->id,362);
            if($result){
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
//        居然是空的，所以很明显，刚刚数据并没有更新成功。
//经过一番调试以后，原来是因为我们没有在 User.php 模型文件中，将 introduction 字段添加至 $fillable 属性中。$fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则忽略。我们只需请按下图新增字段即可
//或者使用下面方法
//        $user->name = $data['name'];
//        $user->introduction = $data['introduction'];
//        $user->save();
        return redirect()->route("users.show",$user->id)->with("success","个人资料更新成功");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
