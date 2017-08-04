<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* Message Model.
*/
class Message extends Model
{
    public $incrementing = false;
    protected $table = 'messages';
    protected $primaryKey = 'msg_id';

    protected $msg_id;
    protected $msg;
    
    protected $key_salt;
    protected $crypto_iv;
}
