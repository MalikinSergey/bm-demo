<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMessage;
use App\Models\Family;
use App\Models\Pack;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function form()
    {
        return view('website.contact.form', []);
    }

    public function send(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'name' => 'required', 'message' => 'required']);

        # recaptcha
        $client = new Client();
        $response = $client->request(
            'POST',
            'https://www.google.com/recaptcha/api/siteverify',

            [
                'form_params' => [
                    'secret' => config('services.recaptha.secret'),
                    'response' => request()->input('g-recaptcha-response')
                ]
            ]
        );

        $body = (string)$response->getBody();

        $body = json_decode($body, true);

        $success = data_get($body, 'success');

        if (!$success) {
            dd('you are robot');
        }

        \Mail::to(['malikin.sergey.1988@gmail.com', 'ilya@boyko.pictures'])->send(new ContactFormMessage($request->only('email', 'name', 'message')));

        session()->put('contact_form_sent', true);

        return redirect()->route('website.contact.success');
    }

    public function success()
    {
        return view('website.contact.success', []);
    }

}
