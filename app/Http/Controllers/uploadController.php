<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class uploadController extends Controller
{

    public function upload(Request $request)
    {
        $destinationPath = "avatars/";

        $image = $request->file('image');

        $response = array('success' => false);

        if ($image->isValid()) {


            $ext = $image->getClientOriginalExtension();
            $fileName = time() . uniqid() . '.' . $ext;


            $uploadSuccess = $image->move($destinationPath, $fileName);

            if ($uploadSuccess) {
                $response['success'] = true;
                $response['image'] = $fileName;
            }
        }

        return Response::json($response);

    }
}
