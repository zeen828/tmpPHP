<?php

namespace App\Notifications\Sms;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Libraries\Traits\Info\Format\Response;
use App\Libraries\Cells\Service\Every8d\SendCell;

/**
 * Class Every8dTelecomer.
 *
 * @package App\Notifications\Sms
 */
class Every8dTelecomer extends Notification implements ShouldQueue
{
    use Queueable;
    use Response;

    /**
     * The phone.
     *
     * @var string
     */
    public $phone;

    /**
     * The subject.
     *
     * @var string
     */
    public $subject;

    /**
     * The message.
     *
     * @var array
     */
    public $message;

    /**
     * Create a new notification instance.
     *
     * @param string $phone
     * @param string $message
     * @param string $subject
     * @return void
     */
    public function __construct(string $phone, string $message, string $subject = '')
    {
        /* Required information */
        $this->phone = $phone;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['sms'];
    }

    /**
     * Get the SMS representation of the notification.
     * 
     * @param  mixed  $notifiable
     * @return array
     * @throws \Exception
     */
    public function toSms($notifiable): array
    {
        return SendCell::input([
            'subject' => $this->subject,
            'content' => $this->message,
            'phone' => $this->phone
        ])->run();
    }
}