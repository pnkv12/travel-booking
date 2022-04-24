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
        [GET]/signup
    */
    public function signupAction()
    {
        return view('user.signup-form');
    }

    /* 
        [POST]/confirmSignUp
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
        Different redirect based on roles
    */
    public function loginAction()
    {
        if (!empty(auth()->user())) {
            if (auth()->user()->role == "Admin") {
                return redirect('/main');
            } else {
                return redirect('/collab');
            }
        } else {
            return view('user.login-form');
        };
    }

    /* 
        [GET]/main
        Authorized
    */
    public function adminAction()
    {
        return view('user.index');
    }

    /* 
        [GET]/collab
        Authorized
    */
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

        if (Auth::attempt($login)) {
            // After login, check role for dashboard redirect
            if (auth()->user()->role == "Admin") {
                return redirect('/main');
            } else {
                return redirect('/collab');
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
        [GET]/admin
    */
    public function viewAction(Request $request)
    {
        $search = $request->all();
        $data   = $this->__user->getList($search);

        return view('user.list', ['data' => $data]);
    }

    /* 
        [GET]/admin/profile/{id}
        Show user's personal profile
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
        [GET]/admin/edit/{id}
        User edit their own details
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
        [POST]/admin/update
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
        [GET]/admin/changepassword/{id}
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
        [POST]/admin/confirmchange
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

    /* 
        [DELETE]/admin/delete/{id}
    */
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

    /* 
        [POST]/admin/change-role
        Admin account can change role of any user
    */
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
