<?php

namespace App\Http\Controllers;

use App\Message;
use App\Crypto\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ReadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function read($id)
    {
        $msg = Message::where('msg_id', $id)->first();

        //validation
        if (empty($msg)) {
            return view('message.info', [
                'page_header' => __('errors.message_not_found_header'),
                'info' => __('errors.message_not_found_body'),
                'extra_info' => __('errors.message_not_found_info'),
            ]);
        }

        return view('message.locker',[
                'id' => $id,
            ]);
    }

    public function readHandle(Request $request, $id)
    {
        $msg = Message::where('msg_id', $id)->first();

        //validation
        if (empty($request->input('password'))) {
            return redirect()->back()->withErrors((new MessageBag)->add('errors', __('errors.empty_password')));
        }
        if (empty($msg)) {
            return view('message.info', [
                'page_header' => __('errors.message_not_found_header'),
                'info' => __('errors.message_not_found_body'),
                'extra_info' => __('errors.message_not_found_info'),
            ]);
        }

        //decrypt
        $ciphertext = base64_decode($msg->msg);
        $psw = $request->input('password');
        $iv = base64_decode($msg->crypto_iv);
        $salt = base64_decode($msg->key_salt);
        $plaintext = Crypto::decrypt($ciphertext, $psw, $iv, $salt);

        //return decrypted message
        if (empty($plaintext)) {
             return redirect()->back()->withErrors((new MessageBag)->add('errors', __('errors.password_incorrect')));
        }
        
        $msg->forceDelete();
        return view('message.info', [
                'page_header' => __('ui.decrypted_header'),
                'info' => $plaintext,
                'extra_info' => __('ui.decrypted_info'),
            ]);
    }
}
