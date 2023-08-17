<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EoiStatusChanged extends Notification
{
    use Queueable;

    private $eoi;
    private $created_by;
	private $msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($eoi, $created_by,$msg)
    {
        //
        $this->eoi         = $eoi;
        $this->created_by  = $created_by;
		$this->msg  = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
       return ['database', 'mail'];
		//return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       //push_notification($notifiable->id);

        return (new MailMessage)
                    ->line($this->msg . " : ". $this->eoi->name)
					->line('Changed By' . " : ". $this->created_by->first_name. " ". $this->created_by->last_name)
                    
                    ->action('View Expression of Interest', route('show_eoi_page', $this->eoi->id));
                    //->line('Thank you for using our application!')
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {        

        return [
            //
            'message' => $this->msg . " : ". $this->eoi->name ,
            'url'  => route('show_eoi_page', $this->eoi->id),
        ];
    }
}
