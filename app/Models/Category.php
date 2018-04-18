<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//我们需要创建『分类模型（Model）』来跟数据库进行交互，创建的命令很简单。但请记住，所有我们新建的模型文件都要统一放置在 app/Models 文件夹下，为此我们在创建一个新的模型对象时，需要在模型名称前面加上 Models 目录。
//$ php artisan make:model Models/Category -m
//-m 选项意为顺便创建数据库迁移文件（Migration）。使用 git status 查看文件创建状态：
class Category extends Model
{

//我们将会为 项目准备以下分类：
//分享 —— 分享创造，分享发现；
//教程 —— 教程相关文章；
//问答 —— 用户问答相关的帖子；
//公告 —— 站点公告类型的帖子。

//每当我们创建完数据模型后，都需要设置 Category 的 $fillable 属性：
    protected $fillable = [
        'name','description',
    ]
}
