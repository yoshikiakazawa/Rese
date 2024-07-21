<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendNotificationRequest;
use App\Models\User;

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
        $emailsSent = false;

        foreach ($users as $user) {
            if (!empty($user->email_verified_at)) {
                Mail::to($user->email)->send(new NotificationMail($subject, $messageContent));
                $emailsSent = true;
            }
        }

        if ($emailsSent) {
            return redirect()->route('admin.send-notification')->with('message', 'お知らせメールを送信しました');
        } else {
            return redirect()->route('admin.send-notification')->with('message', '認証済みのユーザーが見つかりません');
        }
    }
}
