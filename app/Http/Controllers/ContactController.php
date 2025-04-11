<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('cnotact');
    }

    public function send(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

      /*  // يمكنك هنا إرسال البريد الإلكتروني أو حفظ البيانات في قاعدة البيانات
        // مثال على إرسال البريد:
        \Illuminate\Support\Facades\Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email'], $data['name']);
            $message->to('example@mail.com', 'Admin')->subject($data['subject']);
        });*/
        


        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
}
