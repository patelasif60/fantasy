<?php

namespace App\Services;

use App\Mail\Manager\ContactUs;
use Mail;

class ContactUsService
{
    /**
     * Create a new service instance.
     *
     * @param ConsumerRepository $repository
     */
    public function __construct()
    {
    }

    public function sendEmail($data, $user)
    {
        Mail::to(config('fantasy.contact_us_email'))->send(new ContactUs($data, $user));

        return true;
    }
}
