<?php

namespace App\Notifications;

use App\Models\System\Parameter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    private $assigned_password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($assigned_password)
    {
        $this->assigned_password = $assigned_password;
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
     */
    public function toMail($notifiable)
    {
        $message = trans('messages.notifications.welcome.message', ['name' => $notifiable->name, 'password' => $this->assigned_password]);
        $mail = (new MailMessage)->subject(trans('messages.notifications.welcome.title', ['name' => $notifiable->name]));
        $param_code = 'TEMPLATE_WELCOME_NOTIFICATION';
        $template = Parameter::byCode($param_code);
        if (!$template)
            $template = '<p> {{$message}} </p>';
        $rendered = view(['template' => $template], ['user' => $notifiable, 'message' => $message])->render();
        $mail->view('mails.rendered', ['html_content' => $rendered]);
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
        // Todo: check if message exist in params else use in translation messages
        $message = trans('messages.notifications.welcome.message', ['name' => $notifiable->name, 'password' => $this->assigned_password]);
        return [
            'title' => trans('messages.notifications.welcome.title', ['name' => $notifiable->name]),
            'message' => $message
        ];
    }
}
