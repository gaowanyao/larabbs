<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        当用户上传分辨率太小的图片时，会影响网站的美观，所以我们需要对图片的分辨率大小加以限制。得益于 Laravel 强大的表单验证功能，我们只需要在 UserRequest 中增加图片验证规则即可
        return [
//            'name' => 'required|between:2,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'name' => 'required|between:2,25|unique:users,name,' . Auth::id(),
//            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }


//messages() 方法是 表单请求验证（FormRequest）一个很方便的功能，允许我们自定义具体的消息提醒内容，键值的命名规范 —— 字段名 + 规则名称，对应的是消息提醒的内容
//rules() 方法中新增了图片比例验证规则 dimensions ，仅允许上传宽和高都大于 200px 的图片；
//messages() 方法中新增了头像出错时的提示信息。
    public function messages(){
        return [
            'name.unique' => '用户名已被占用，请重新填写',
//            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 2 - 25 个字符之间',
            'name.required' => '用户名不能为空',
            'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
}
