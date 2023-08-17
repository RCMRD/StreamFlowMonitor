<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EoiCreated extends Notification
{
    use Queueable;

    private $eoi;
    private $created_by;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($eoi, $created_by)
    {
        //
        $this->eoi         = $eoi;
        $this->created_by  = $created_by;
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
                    ->line('New Expression of Interest has been created for your Approval for development' . " : ". $this->eoi->name)
					->line('Created By' . " : ". $this->created_by->first_name. " ". $this->created_by->last_name)
                    
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
            'message' => 'New Expression of Interest has been created for your Approval for development' . " : ". $this->eoi->name ,
            'url'  => route('show_eoi_page', $this->eoi->id),
        ];
    }
}
