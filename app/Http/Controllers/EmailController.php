<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\EmailSender;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    //Class attribute for handling mail requests.
    private $mailer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mailer = new EmailSender();
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'msg' => ['required', 'string'],
            'recipientId' => ['required']
        ]);
    }

    /**
     * Shows the email page, finding the recipient in the database so that the name and email can be displayed.
     *
     * @param  String $recipientId 
     */
    public function onPageLoad(String $recipientId) {
        $recipientUser = User::find(htmlspecialchars($recipientId));
        return view('sendEmail', ["user" => $recipientUser]);
    }

    /**
     * Handles the POST request for sending an email, validating that the recipient ID is present and a message has been
     * provided. Calls $mailer to send the email via the API.
     * Redirects back to home once complete.
     *
     * @param  Request $request 
     */
    public function onSubmit(Request $request) {
        $data = $request->input();
        $validationResult = $this->validator($request);
        if($validationResult->fails()) {
            return redirect('send-mail/'. $data["recipientId"])->withErrors($validationResult);
        } else {
            $recipientUser = User::find(htmlspecialchars($data["recipientId"]));
            $this->mailer->sendMail($recipientUser->email, htmlspecialchars($data["msg"]));
            return redirect('/');
        }
    }


}
