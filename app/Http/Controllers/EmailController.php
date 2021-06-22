<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\EmailSender;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    private $mailer;

    public function __construct()
    {
        $this->middleware('auth');
        $this->mailer = new EmailSender();
    }

    protected function validator(Request $request, array $messages)
    {
        return Validator::make($request->all(), [
            'msg' => ['required', 'string'],
            'recipientId' => ['required']
        ], $messages);
    }

    public function onPageLoad(String $recipientId) {
        if($recipientId == Auth::id()) {
            return redirect('/');
        }
        $recipientUser = User::find(htmlspecialchars($recipientId));
        return view('sendEmail', ["user" => $recipientUser]);
    }

    public function onSubmit(Request $request) {
        $data = $request->input();
        $customMessages = [
            'image' => 'All image files must be an image e.g. .png, .jpg.'
        ];
        $validationResult = $this->validator($request, $customMessages);
        if($validationResult->fails()) {
            return redirect('send-mail/'. $data["recipientId"])->withErrors($validationResult);
        } else {
            $thisUser = User::find(Auth::id());
            $recipientUser = User::find(htmlspecialchars($data["recipientId"]));
            if($thisUser == null) {
                return redirect('send-mail/');
            } else {
                $this->mailer->sendMail($thisUser->name, $recipientUser->email, htmlspecialchars($data["msg"]));
                return redirect('/');
            }
        }
    }


}
