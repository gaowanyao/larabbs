<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
//define 定义了一个指定数据模型（如此例子 User）的模型工厂。define 方法接收两个参数，第一个参数为指定的 Eloquent 模型类，第二个参数为一个闭包函数，该闭包函数接收一个 Faker PHP 函数库的实例，让我们可以在函数内部使用 Faker 方法来生成假数据并为模型的指定字段赋值。
//我们需要增加 introduction 用户简介字段的填充，另外我们计划在 UsersTableSeeder 里使用 批量入库 的方式填充数据，因此需要自行填充 created_at 和 updated_at 两个字段

//Faker 是一个假数据生成库，sentence() 是 faker 提供的 API ，随机生成『小段落』文本。我们用来填充 introduction 个人简介字段。
//Carbon 是 PHP DateTime 的一个简单扩展，这里我们使用 now() 和 toDateTimeString() 来创建格式如 2017-10-13 18:42:40 的时间戳。

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    $now = Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
//        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'password' => $password?:$password=bcrypt('secret'), // 密码是secret
        'remember_token' => str_random(10),
        'introduction' => $faker->sentence(),
        'created_at' =>$now,
        'updated_at' => $now,
    ];
});
