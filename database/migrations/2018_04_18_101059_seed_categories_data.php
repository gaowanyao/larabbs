<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{

//初始化分类数据
//我们想要 LaraBBS 论坛软件在安装的时，就初始化本文最前面提到的四个分类。
//面对数据库内容填充的需求，一般情况下我们会使用 Laravel 的 『数据填充 Seed』 。可是在当下场景中，我们无法使用此功能。此一般是用来生成假数据，而现在我们需要生成的是项目的 初始化数据，这些数据是项目运行的一部分，在生产环境下也会使用到，而数据填充只能在开发时使用。
//虽然 Laravel 没有自带此类解决方案，不过数据迁移功能倒是比较不错的替代方案。在功能定位上，数据迁移也是项目的一部分，执行的时机刚好是在项目安装时。并且区分执行先后顺序，这确保了初始化数据发生在数据表结构创建完成后。
//接下来我们使用命令生成数据迁移文件，作为 初始化数据 的迁移文件，我们定义命名规范为 seed_(数据库表名称)_data ：
//$ php artisan make:migration seed_categories_data

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'=>'分享',
                'description'=>'分享创造，分享发现',
            ],
            [
                'name'=>'教程',
                'description'=>'开发技巧，推荐扩展包等',
            ],
            [
                'name'=>'问答',
                'description'=>'请保持友善，互帮互助',
            ],
            [
                'name'=>'公告',
                'description'=>'站点公告',
            ],
        ];
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate(); //删除整表，不能恢复，谨慎使用
    }
    //代码解析：
    //up() 方法中使用 DB 类的 insert() 批量往数据表 catetories 里插入数据 $catetories；
    //down() 在回滚迁移时会被调用，是 up() 方法的逆反操作。truncate() 方法为清空 catetories 数据表里的所有数据。

}
