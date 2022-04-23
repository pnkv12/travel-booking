<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
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

    /* 
        Open signup page
    */
    public function signupAction()
    {
        return view('user.signup-form');
    }

    /* 
        Confirm Signup with validation
    */
    public function confirmSignUpAction(RegisterRequest $request)
    {
        $user               = $request->except('_token');
        $user['password']   = Hash::make($user['password']);
        $user['created_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');
        $user['role'] = "Collab";

        $request->validate([
            'fullname'    => 'required',
            'email'       => 'required|email',
            'username'    => 'required|unique:users|min:6|max:12',
            'password'    => 'required|min:6',
            'phone'       => 'required|digits:10',
        ]);

        try {
            $this->__user->regUser($user);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return redirect()->route('user.login');
    }

    /* 
        [GET]/login
    */
    public function loginAction()
    {

        if (!empty(auth()->user())) {
            if (auth()->user()->role == "Admin") {
                return redirect()->to('/main');
            } else {
                return redirect()->to('/collab');
            }
            // return redirect()->route('user.main');
        } else {
            return view('user.login-form');
        };
    }

    /* 
        [GET]/admin
    */
    public function adminAction()
    {
        return view('user.index');
    }

    // [GET]/collab
    public function collabAction()
    {
        return view('user.collab-index');
    }

    /* 
       [POST]/postLogin
    */
    public function postLoginAction(LoginRequest $request)
    {
        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // $role = auth()->user()->role;

        if (Auth::attempt($login)) {
            if (auth()->user()->role == "Admin") {
                return redirect()->to('/main');
            } else {
                return redirect()->to('/collab');
            }
        } else {
            return redirect()->back()->with('status', 'Username or Password is incorrect.');
        }
    }


    /* 
        [GET]/logout
    */
    public function logoutAction()
    {
        Auth::logout();
        return redirect('/login');
    }

    /* 
        Show Admin contacts list
    */
    public function viewAction(Request $request)
    {
        $search = $request->all();
        $data   = $this->__user->getList($search);

        return view('user.list', ['data' => $data]);
    }

    /* 
        Show each Admin's profile
        Authorized
    */
    public function profileAction(Request $request)
    {
        $id = $request->id;
        $id = Auth::id();
        $data = $this->__user->viewProfile($id);

        return view('user.profile', ['data' => $data]);
    }

    /* 
        Show edit page for Admin's profile
        Authorized
    */
    public function editAdAction(Request $request)
    {
        $id   = $request->id;
        $id = Auth::id();
        $data = $this->__user->getUserById($id);

        return view('user.edit', ['data' => $data]);
    }

    /* 
        Update Admin's profile
    */
    public function updateAction(Request $request)
    {
        $user               = $request->except('_token');
        $user['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        $request->validate([
            'fullname' => 'required',
            'email'    => 'required|email',
            'phone'    => 'required|digits:10'
        ]);
        try {
            $this->__user->updateAdmin($user);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Yippi~ Your info has been updated!"
        ]);
    }

    /* 
        Change password in an admin account
        Authorized
    */
    public function changePWAction(Request $request)
    {
        $id   = $request->id;
        $id = Auth::id();
        $data = $this->__user->getUserPassword($id);

        return view('user.password', ['data' => $data]);
    }

    /* 
        Confirm password change
    */
    public function confirmPWAction(Request $request)
    {
        $user               = $request->except('_token');
        $user['password']   = Hash::make($user['password']);
        $user['password_confirmation'] = Hash::make($user['password_confirmation']);
        $user['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');

        $request->validate([
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'min:6',
        ]);
        try {
            $this->__user->updatePw($user);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Your password changed!"
        ]);
    }

    public function deleteUserAction(Request $request)
    {
        $id = $request->id;

        try {
            $this->__user->deleteUser($id);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Success!"
        ]);
    }

    public function changeRoleAction(Request $request)
    {
        $role               = $request->except('_token');
        $role['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:00');
        try {
            $this->__user->changeRole($role);
        } catch (Exception $ex) {
            return response()->json([
                'error'   => true,
                'message' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'error'   => false,
            'message' => "Role changed."
        ]);
    }
}
