<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadPhotoAction()
    {
        return view('image.upload');
    }

    public function postPhotoAction(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        /* Store $imageName name in DATABASE from HERE */

        return back()
            ->with('success', 'You have successfully upload image.')
            ->with('image', $imageName);
    }
}
