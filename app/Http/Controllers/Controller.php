<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadimage($img,$name)
    {
        $valid_img = array("jpg", "jpeg", "png", "gif", "svg");
        $valid_video = array("mp4", "mkv","pdf","docx","doc");
        if ($img->file($name) && in_array($img->$name->extension(), $valid_img)) {
            $imagePath = $img->file($name);
            $imageName =  $imagePath->getClientOriginalName();
             $imageName=rand().$imageName;
            $path = $img->file($name)->storeAs('uploads', $imageName, 'public');
            if ($img->$name->extension() != "svg") {
                $this->createthumb($imageName, 100, 'thumb');
            }
            return $imageName;
        }elseif($img->file($name) && in_array($img->$name->extension(), $valid_video)) {
            $imagePath = $img->file($name);
            $imageName = $imagePath->getClientOriginalName();
            $imageName=rand().$imageName;
            $path = $img->file($name)->storeAs('uploads', $imageName, 'public');
            return $imageName;
        }
    }
    public function replaceimage($img,$name,$file)
    {
        Storage::delete('/public/uploads/' . $file);
        Storage::delete('/public/uploads/thumb/' . $file);

        $valid_img = array("jpg", "jpeg", "png", "gif","svg");
        $valid_video = array("mp4", "mkv","pdf","docx","doc");
        if ($img->file($name) && in_array($img->$name->extension(), $valid_img)) {
            $imagePath = $img->file($name);
            $imageName = $imagePath->getClientOriginalName();
            $imageName = rand() . $imageName;
            $path = $img->file($name)->storeAs('uploads', $imageName, 'public');
            if ($img->$name->extension() != "svg"){
                $this->createthumb($imageName, 160, 'thumb');
        }
            return $imageName;
        }elseif($img->file($name) && in_array($img->$name->extension(), $valid_video)) {
            $imagePath = $img->file($name);
            $imageName = $imagePath->getClientOriginalName();
            $imageName=rand().$imageName;
            $path = $img->file($name)->storeAs('uploads', $imageName, 'public');
            return $imageName;
        }
    }

    public static function createthumb($url, $width, $dir) {
        ################create thumb
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR );
        $dest=$path. $url;

        $image_info = @getimagesize($dest);
        $image_type = $image_info[2];
        $height = floor($image_info[1] * ( $width / $image_info[0]));
        if ($width > $image_info[0]) {
            $width = $image_info[0];
            $height = $image_info[1];
        }

        $image = @imagecreatefromjpeg($dest) or // Read JPEG Image
        $image = @imagecreatefrompng($dest) or // or PNG Image
        $image = @imagecreatefromgif($dest) or // or GIF Image
        $image = false; // If image is not JPEG, PNG, or GIF
        $new_image = imagecreatetruecolor($width, $height);
        $whiteBackground = imagecolorallocate($new_image, 255, 255, 255);
        imagefill($new_image, 0, 0, $whiteBackground);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
        imagejpeg($new_image, $path . $dir . DIRECTORY_SEPARATOR . "$url", 100);
        ################create thumb
    }
    public function uploadimagemultiple($img)
    {
        $valid_img = array("jpg", "jpeg", "png", "gif", "svg");
        $valid_video = array("mp4", "mkv","pdf","docx","doc");
        if ($img && in_array($img->extension(), $valid_img)) {
            $imagePath = $img;
            $imageName =  $imagePath->getClientOriginalName();
            $imageName=rand().$imageName;
            $path = $img->storeAs('uploads', $imageName, 'public');
            if ($img->extension() != "svg") {
                $this->createthumb($imageName, 100, 'thumb');
            }
            return $imageName;
        }elseif($img && in_array($img->extension(), $valid_video)) {
            $imagePath = $img;
            $imageName = $imagePath->getClientOriginalName();
            $imageName=rand().$imageName;
            $path = $img->storeAs('uploads', $imageName, 'public');
            return $imageName;
        }
    }

}
