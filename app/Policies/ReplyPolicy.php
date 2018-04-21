<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {

//        dump($reply->user_id);
//        dump($reply->topic->user_id);
//        dd($user->id);
//        自己的帖子可以删除别人的回复，以及别人的帖子可以自己删除自己的回复
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
//        return true;
    }
}
