<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class Admin_Auth_Controller extends Controller
{
    use ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $user;
    protected $redirectPath = 'admin/home';

    protected $loginPath = 'admin/login';
    /**
     * The Guard implementation.
     *
     * @var Authenticator
     */
    protected $auth;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth, User $user)
    {
        $this->user = $user;
        $this->auth = $auth;

        $this->middleware('guest', ['except' => ['getLogout']]);
    }

    public function getLogin()
    {

        $this->data['page_title'] = 'Super admin Login';
        return view('admin.auth.login')->with($this->data);
    }

    public function postLogin(Request $request)
    {
        $messages = array(
            'g-recaptcha-response.required' => 'The recaptcha field is required.'
        );

        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            //'g-recaptcha-response' => 'required|captcha'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $credentials = [
                'user_name' => $request->user_name,
                'password' => $request->password
            ];

            if (Auth::attempt($credentials)) {
                $user = $this->auth->user();

                if ($user->status == 0) {
                    Session::flash('error_flash_message', 'User account not activated');
                    $this->auth->logout();
                    return redirect('/admin/login');
                } else {
                    return redirect('/admin/home');
                }
            } else {
                Session::flash('error_flash_message', 'Incorrect username or password');
                return redirect('/admin/login');
            }
        }
    }

    public function getLogout()
    {
        $this->auth->logout();
        return redirect('/admin/login');
    }
}
