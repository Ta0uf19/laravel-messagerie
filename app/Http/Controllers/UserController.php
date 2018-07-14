<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoUpload;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    private $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function uploadPhoto(PhotoUpload $req)
    {
        $avatar = $req->file('avatar');

        if ($avatar->isValid()) {
            $path = public_path('uploads/avatars/'); // helper config
            $name = str_random(10).'.'.$avatar->getClientOriginalExtension(); // name
            $image = Image::make($avatar)->resize(300, 300);

            if ($image->save($path.$name)) {
                //changer photo pour l'utilsateur
                $this->repo->update(Auth::user()->id, ['avatar' => $name]);

                return redirect('profile')->with('success', 'Photo uploader avec succès');
            }
        }

        return redirect('profile')->with('errors', 'Extension fichier non permis');
    }
}
