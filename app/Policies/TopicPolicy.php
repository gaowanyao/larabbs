<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
//        在授权策略的类方法里，返回 true 即允许访问，反之返回 false 为拒绝访问。
        return $user->isAuthorOf($topic);
//         return $topic->user_id == $user->id;
//        return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
//        return $topic->user_id == $user->id;
//        return true;
    }
}
