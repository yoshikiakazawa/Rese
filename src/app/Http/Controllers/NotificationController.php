<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendNotificationRequest;

class NotificationController extends Controller
{
    public function showForm()
    {
        return view('admin.notification_mail');
    }

    public function sendNotification(SendNotificationRequest $request)
    {

        $subject = $request->input('subject');
        $messageContent = $request->input('message');
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($subject, $messageContent));
        }

        return redirect()->route('admin.send-notification')->with('success', 'お知らせメールを送信しました。');
    }
}
