<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//php artisan make:migration add_avatar_and_introduction_to_users_table --table=users  生成迁移文件
//接着我们还需要运行迁移，将字段加入到用户表中：
//php artisan migrate 

class AddAvatarAndIntroductionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('avatar')->nullable();
            $table->string('introduction')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('avatar');
            $table->dropColumn('introduction');
        });
    }
}
