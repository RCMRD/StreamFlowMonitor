<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalCreated extends Notification
{
    use Queueable;

    private $proposal;
    private $created_by;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proposal, $created_by)
    {
        //
        $this->proposal         = $proposal;
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
                    ->line('New Proposal has been created for your Approval for development' . " : ". $this->proposal->name)
					->line('Created By' . " : ". $this->created_by->first_name. " ". $this->created_by->last_name)
                    
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
            'message' => 'New Proposal has been created for your Approval for development' . " : ". $this->proposal->name ,
            'url'  => route('show_proposol_page', $this->proposal->id),
        ];
    }
}
