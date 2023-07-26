<?php
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
if (!function_exists('DownloadImage')) {
    function DownloadImage($name)
    {
        $exists = Storage::disk('s3')->has('images/' . $name);
        return ($exists) ?
            Storage::disk('s3')->response('images/' . $name) :
            responseStatus('Image is not found', 404);
    }
}

if (!function_exists('UploadImage')) {
    function UploadImage($request, $image_name){

        $original_image = $request->file($image_name);
        $extension = $original_image->getClientOriginalExtension();
        return  ($extension == 'gif') ? GetImage($original_image,'gif') : StoreImage($original_image);
    }
}
#ksk
if (!function_exists('StoreImage')) {
    function StoreImage($original_image): string{
        return GetImage($original_image,'webp');
    }
}

if (!function_exists('GetImage')) {
    function GetImage($original_image,$format): string{
        $file_name = now()->format('mdHYisu') . '.'. $format;
        $file_path = 'images'.'/'.$file_name;
        $image = Image::make($original_image);
        if($format == 'webp'){
            $image
                ->encode($format, 30)
                ->resize( $image->width(), $image->height(),function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
        }
        
        Storage::disk('s3')->put($file_path,   $image->stream());
        return Storage::disk('s3')->url($file_path);
    }
}



if (!function_exists('ImageLink')) {
    function ImageLink($file_name){
        if($file_name == null ) return null;
        $file_path = 'images'.'/'.$file_name;
        return Storage::disk('s3')->url($file_path);
    }
}


if (!function_exists('DeleteOldPhoto')) {
    function DeleteOldPhoto($images)
    {
        if ($images) {
            foreach ($images as $img) {
                DeleteImage($img->name);
            }
        }

    }
}


if (!function_exists('MultipleUploadImage')) {
    function MultipleUploadImage($request, $image_name)
    {
        $multi_photo = $request->file($image_name);
        foreach ($multi_photo as $multi) {
            $path[] = StoreImage($multi);
        }
        return $path;
    }
}

if (!function_exists('DeleteImage')) {
    function DeleteImage($file_path){
        if (!is_null($file_path)) {
            $image_name = basename($file_path);
            Storage::disk('s3')->delete('images/' . $image_name);
        }
    }
}
