<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;
use App\Handlers\ImageUploadHander;

class TopicsController extends Controller
{
    public function __construct()
    {
//        'except' => ['index', 'show'] —— 对除了 index() 和 show() 以外的方法使用 auth 中间件进行认证。
//        $this->test();
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function test(){
        $int1 = 1;
        $int2 = 2;
        $int3 = 1;
        echo $int1 <=> $int3;
        echo "<br/>";
        echo $int1 <=> $int2;
        echo "<br/>";
        echo $int2 <=> $int3;
        die();
    }

	public function index(Request $request,Topic $topic, User $user,Link $link)
	{
//        为了读取 user 和 category，每次的循环都要查一下 users 和 categories 表，在本例子中我们查询了 30 条话题数据，那么最终我需要执行的查询语句就是 30 * 2 + 1 = 61 条语句。如果我第一次查询出来的是 N 条记录，那么最终需要执行的 SQL 语句就是 N+1 次：
//        https://d.laravel-china.org/docs/5.4/eloquent-relationships#eager-loading
//        方法 with() 提前加载了我们后面需要用到的关联属性 user 和 category，并做了缓存。后面即使是在遍历数据时使用到这两个关联属性，数据已经被预加载并缓存，因此不会再产生多余的 SQL 查询：

//        dump($request->order);
        $topics = $topic->withOrder($request->order)->paginate(10);

        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
//        dd($active_users);
		return view('topics.index', compact('topics', 'active_users', 'links'));
	}

    public function show(Request $request,Topic $topic)
    {

//        我们需要访问用户请求的路由参数 Slug，在 show() 方法中我们注入 $request；
//! empty($topic->slug) 如果话题的 Slug 字段不为空；
//    && $topic->slug != $request->slug 并且话题 Slug 不等于请求的路由参数 Slug；
//redirect($topic->link(), 301) 301 永久重定向到正确的 URL 上。
        if(!empty($topic->slug) && $topic->slug != $request->slug){
            return redirect($topic->link(),301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{

//	    dump(Auth::id());
//	    dd($request->all());
//        $topic = Topic::create($request->all());
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->to($topic->link())->with('message', '成功创建话题!');
//        return redirect()->route('topics.show', $topic->id)->with('message', '成功创建话题!');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic','categories'));
    }

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', '更新成功！');
//		return redirect()->route('topics.show', $topic->id)->with('message', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '成功删除！');
	}

    public function uploadImage (Request $request,ImageUploadHander $uploader)
    {
        //初始化返回数据，默认是失败的
        $data = [
            'success'=>false,
            'msg'=>'上传失败!',
            'file_path'=>''
        ];
        //判断是否有上传文件，并赋值给$file
        if($file = $request->upload_file){
            //保存图片到本地
            $result = $uploader->save($request->upload_file,'topics',\Auth::id(),1024);

            if($request){
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
	}
}