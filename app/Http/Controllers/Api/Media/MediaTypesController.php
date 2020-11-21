<?php

namespace App\Http\Controllers\Api\Media;

use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaTypesController extends Controller
{
    public function index()
    {
        // $mt = new MimeTypes();//static methos declare na korle evabe object baniye call korte hobe
        // return  $mt->abc();

        return response()->json([
            'data' => [
                'image' => MimeTypes::$image,
                'video' => MimeTypes::$video,
            ]
        ]);
    }
}
