<?php

namespace SocialMedia\Poster\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 2;

    public $timeout = 10;

    public $content;

    public $file;

    public $notification;

    public $to;

    public function __construct($content = [], $file = null, $to = 'nafezly', $notification = true)
    {
        $this->content = $content;
        $this->file = $file;
        $this->notification = $notification;
        $this->to = $to;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $content = '';
        foreach ($this->content as $con)
        {
            if (is_link($con))
            {
                $content = $content . '\n[افتح الرابط](' . $con . ')' . ' ';
            }
            else
            {
                $content = $content . $con . ' ';
            }
        }

        if ($this->file != null)
        {
            return TelegramFile::create()->to('@' . $this->to)
                ->content($content)->file($this->file, 'photo')->disableNotification(!$this->notification);
        }
        else
        {
            return TelegramMessage::create()->to('@' . $this->to)
                ->content($content)->disableNotification(!$this->notification);
        }
    }
}
