<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;
    protected $fillable=[
        'comment',
        'photo',
        'date_time',
        'replyable_id',
        'replyable_type',
        'support_ticket_id',
    ];
 
    public function replyable(){
        return $this->morphTo();
    }
}
