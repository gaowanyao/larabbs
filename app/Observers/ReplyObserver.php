<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
//        话题回复的内容限定与话题的内容无异，因此我们使用同样的过滤规则 —— user_topic_body 。
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count',1);
    }

    public function updating(Reply $reply)
    {
        //
    }
}