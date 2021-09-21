<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthenticatesUsers;
    
    protected $__user;

    public function __construct(User $user)
    {
        $this->__user = $user;
    }

    public function signupAction()
    {
        return view('user.signup-form');
    }

    public function confirmSignUpAction(Request $request)
    {
        $user             = $request->except('_token');
        $user['password'] = Hash::make($user['password']);

        $request->validate([
            'fullname'    => 'required',
            'email'       => 'required',
            'username'    => 'required|min:6|max:12',
            'password'    => 'required|min:6',
            'phone'       => 'required|digits:10',
        ]);

        try
        {
            $this->__user->regUser($user);
        }
        catch(Exception $ex)
        {
            return $ex->getMessage();
        }
        return redirect()->route('user.login');
    }

    public function loginAction()
    {

        if(!empty(auth()->user())){
            return redirect()->route('user.index');
        }
        else{
            return view('user.login-form');
        };
    }

    public function postLoginAction(LoginRequest $request)
    {
        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('user.index');
        } else {
            return redirect()->back()->with('status','Email or Password is incorrect.');
        }
    }


    public function indexAction()
    {
        return view('user.index');
    }

    public function logoutAction()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function viewAction()
    {
        $data = $this->__user->getList();
        return view('user.list', ['data' => $data]);
    }
}
