<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StylePhoto extends Model
{
    use HasFactory;
    protected $fillable=['name','type'];


    public function getStylePhoto($id,$type){
        $style_photos= StylePhoto::where([
            ['style_id',$id],
            ['type',$type],
        ])->get();
       return $style_photos;
       
    }
    public function deleteStylePhoto($id,$type){
       return StylePhoto::where([
        ['style_id',$id],
        ['type',$type]
       ])->delete();
    }
}
