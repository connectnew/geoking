<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController as Controller;
use Intervention\Image\Facades\Image;

class ImageUploadController extends Controller
{
    public function upload(Request $request, $type = 'listing'){
    	 $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        $image = $request->file('file');
        $imageName = str_random(5).time();
        $extensions = ['jpg'];
        $destinationPath = storage_path('app/public/' . $type . '/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        foreach($extensions as $extention){
            $image = Image::make($image);
            $image->save($destinationPath .$imageName . '.' . $extention);
        }
        return response()->json(['image_url' => '/' . $type . '/' . $imageName . '.jpg']);
    }
}
