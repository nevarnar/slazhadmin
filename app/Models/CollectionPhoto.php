<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionPhoto extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    public function getCollectionPhoto($id){
        $style_photos= CollectionPhoto::where([
            ['collection_id',$id],
        ])->get();
       return $style_photos;
       
    }
    public function deleteCollectionPhoto($id){
       return CollectionPhoto::where([
        ['collection_id',$id],
       ])->delete();
    }
}
