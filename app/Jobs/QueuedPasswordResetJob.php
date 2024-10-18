<?php
namespace App\Jobs;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Auth\Notifications\ResetPassword;

use Illuminate\Support\Facades\Log;

class QueuedPasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $token;

    public function __construct(User $user, $token)
    {
        //the user property passed to the constructor through the job dispatch method
        $this->user = $user;
        $this->token = $token;
    }

    public function handle()
    {
        //This queued job sends
        //Illuminate\Auth\Notifications\ResetPassword notification
        //to the user by triggering the notification

        $this->user->notify(new ResetPassword($this->token));
    }
}
