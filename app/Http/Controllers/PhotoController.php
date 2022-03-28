<?php

namespace App\Http\Controllers;

use App\Models\ImageTable;

use Exception;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected $__image;

    public function __construct(ImageTable $image)
    {
        $this->__image = $image;
    }

    public function openUploadView()
    {
        $image   = $this->__image->getList();

        return view('layout.photocrud', ['image' => $image]);
    }

    public function postPhoto(Request $request)
    {
        if ($request->hasFile('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
            $size = $request->file('photo')->getSize();
            $request->file('photo')->storeAs('public/image', $name);

            $photoItem = new ImageTable();
            $photoItem->photo_name = $name;
            $photoItem->size = $size;
            $photoItem->save();
        }
        return redirect()->back();
    }


    public function delete(Request $request)
    {
        $id = $request->id;

        try {
            $this->__image->deletePhoto($id);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Photo deleted!"
        ]);
    }
}
