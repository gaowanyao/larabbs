<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
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
        $topic = $reply->topic;
        $topic->increment('reply_count',1);
        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));

//        默认的 User 模型中使用了 trait —— Notifiable，它包含着一个可以用来发通知的方法 notify() ，此方法接收一个通知实例做参数。虽然 notify() 已经很方便，但是我们还需要对其进行定制，我们希望每一次在调用 $user->notify() 时，自动将 users 表里的 notification_count +1 ，这样我们就能跟踪用户未读通知了。

    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }

    public function updating(Reply $reply)
    {
        //
    }
}