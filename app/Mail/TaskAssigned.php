<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;
	private $task;
    private $assigned_by;
	private $account;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $assigned_by,$account)
    {
        //
		$this->task         = $task;
        $this->assigned_by  = $assigned_by;
		$this->account  = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
		
		return $this->subject(__('form.you_have_a_new_task') . " : ". $this->task->title)->view('emails.new-task')->with([
                        'task_id' => $this->task->id,'account' => $this->account,'sender' => $this->assigned_by,'task'=>$this->task
                        
                    ]);
					
					
					
    }
}
