<?php

namespace App\Http\Controllers;

use App\Message;
use App\Crypto\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class HomeController extends Controller
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

    /**
     * Display homepage for creating new message.
     */
    public function new()
    {
        return view('index');
    }

    /**
     * Handle requests for creating new message.
     * 
     * @param Request $request 
     */
    public function newHandle(Request $request)
    {
        if (empty($request->input('password'))) {
            return redirect()->back()->withErrors((new MessageBag)->add('errors', __('errors.empty_password')));
        }
        if (empty($request->input('message'))) {
            return redirect()->back()->withErrors((new MessageBag)->add('errors', __('errors.empty_message')));
        }

        //encrypt
        $buffer = Crypto::encrypt($request->input('message'), $request->input('password'));
        $request->offsetSet('password', null);
        
        $msg = new Message();
        $msg->msg_id = substr(md5(random_bytes(8)),0,8);
        $msg->msg = base64_encode($buffer['ciphertext']);
        $msg->crypto_iv = base64_encode($buffer['iv']);
        $msg->key_salt = base64_encode($buffer['salt']);

        if ($msg->save()) {
            $reply = [
                'page_header' => __('ui.encrypted_header'),
                'info' => config('app.url').'/'.$msg->msg_id,
                'extra_info' => __('ui.encrypted_info'),
            ];
        } else {
            $reply = [
                'page_header' => __('errors.failure_header'),
                'info' => __('errors.failure_body'),
                'extra_info' => __('errors.failure_info'),
            ];
        }

        return view('message.info', $reply);
    }
}
