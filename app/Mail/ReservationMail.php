<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservationDetails;
    public $logoPath;

    /**
     * Create a new message instance.
     *
     * @param array $reservationDetails
     */
    public function __construct($reservationDetails)
    {
        $this->reservationDetails = $reservationDetails;
        $this->logoPath = public_path('landingpage/assets/img/logoname.jpg');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservation')
            ->subject('Reservation Confirmation')
            ->with([
                'details' => $this->reservationDetails,
                'logoPath' => $this->logoPath
            ]);
    }
}
