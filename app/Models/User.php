<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Topic;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
//    use Notifiable;
    use Notifiable{
        notify as protected laravelNotify;
    }
//我们对 notify() 方法做了一个巧妙的重写，
//现在每当你调用 $user->notify() 时，
// users 表里的 notification_count 将自动 +1。
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     * $fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则忽略
     * 添加 introduction 字段
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }


    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }


//在 Eloquent 模型实例中获取或设置某些属性值的时候，访问器和修改器允许你对 Eloquent 属性值进行格式化。有两种方法可以修改 Eloquent 模型属性的值，一种是『访问器』，另一种是『修改器』。
//访问器和修改器最大的区别是『发生修改的时机』，访问器是 访问属性时 修改，修改器是在 写入数据库前 修改。修改器是数据持久化，访问器是临时修改。访问器的使用场景是当数据因为特殊原因存在不一致性时，可以使用访问器进行矫正处理。在我们的密码加密的场景里，我们会使用修改器在密码即将入库前，对其进行加密。
//我们须在模型上定义一个 setPasswordAttribute 方法，注意命名规范是 set{属性的驼峰式命名}Attribute，当我们给属性赋值时，如 $user->password = 'password'，该修改器将被自动调用：
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60){
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }

}
