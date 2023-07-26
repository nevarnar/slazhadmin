<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'photo',
        'date_time',
        'status',
        'ticket_id',
        'admin_id',
        'user_id',
    ];
  
    public function user(){
        return $this->belongsTo(\App\Models\User::class)->
        select('id','name');
    }
    public function admin(){
        return $this->belongsTo(\App\Models\Admin::class)->select('id','full_name');
    }
    public function latest_reply(){
        return $this->hasOne(\App\Models\TicketReply::class)->select('id','date_time',
        'replyable_id','replyable_type','support_ticket_id')->latest();
    }
    public function ticket_reply(){
        return $this->hasMany(\App\Models\TicketReply::class)->select('id','comment','photo','date_time','replyable_id','replyable_type','support_ticket_id');
    }
    public function scopeByStatus($query,$status){
        if($status==='all'){
            return $query->where('status','!=',null);
        }
        return $query->where('status',$status);
    }
}
