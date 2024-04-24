namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // Initialization code
    }

    public function build()
    {
        return $this->subject('Welcome to Our Application!')
                    ->view('emails.send');
    }
}
