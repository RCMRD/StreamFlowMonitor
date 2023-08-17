<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalStatusChanged extends Notification
{
    use Queueable;

    private $proposal;
    private $created_by;
	private $msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proposal, $created_by,$msg)
    {
        //
        $this->proposal         = $proposal;
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
                    ->line($this->msg . " : ". $this->proposal->name)
					->line('Changed By' . " : ". $this->created_by->first_name. " ". $this->created_by->last_name)
                    
                    ->action('View Proposal', route('show_proposol_page', $this->proposal->id));
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
            'message' => $this->msg . " : ". $this->proposal->name ,
            'url'  => route('show_proposol_page', $this->proposal->id),
        ];
    }
}
