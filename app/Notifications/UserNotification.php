<?php

namespace App\Notifications;

use App\Models\System\Parameter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;
    private $message;

    /**
     * Create a new notification instance.
     *
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * @throws \Throwable
     */
    public function toMail($notifiable)
    {
        $message = $this->message;
        $mail = (new MailMessage)->subject("User notification");
        $template = Parameter::byCode('TEMPLATE_USER_NOTIFICATION');
        if (!$template)
            $template = '<p> {!! $message !!} </p>';
        $rendered = view(
            [
                'template' => $template
            ],
            [
                'user' => $notifiable,
                'message' => $message
            ]
        )->render();
        $mail->view('mails.user', ['html_content' => $rendered]);
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
