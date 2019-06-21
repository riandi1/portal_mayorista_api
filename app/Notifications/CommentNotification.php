<?php

namespace App\Notifications;

use App\Models\System\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;
    private $comment;

    /**
     * Create a new notification instance.
     *
     * @param Comment $comment
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $title = trans('messages.notifications.comment.title',[
            'target' => $this->comment->getAttribute('model'),
            'target_id' => $this->comment->target_id
        ]);
        $message = trans('messages.notifications.comment.message', [
            'username' => $this->comment->user->name,
            'message' => $this->comment->message
        ]);
        $data = [
            'comment' => $this->comment
        ];

        return [
            'title' => $title,
            'message' => $message,
            'data' => $data
        ];
    }
}
