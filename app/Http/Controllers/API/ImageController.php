<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function imageStore(Request $request)
    {
        // $this->validate($request, [
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);

        $image_data = base64_decode($request->input('myImageData'));
        $file_name = 'unity/image/' . md5(microtime()) . '.jpg';

        Storage::put('public/' . $file_name, $image_data);

        $data = Content::make([
            'category_id' => 1,
            'title' => 'Unity Image Upload : ' . rand(1, 1000),
            'detail' => 'Unity Image Upload : ' . rand(1, 1000),
            'contentType' => 1,
            'path' => $file_name,
            'isPublished' => true,

        ]);
        $data->save();

        return response($data, Response::HTTP_CREATED);

        // return response($data, Response::HTTP_CREATED);
    }
}
