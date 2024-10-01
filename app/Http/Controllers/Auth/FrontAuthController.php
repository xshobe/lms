<?php

namespace App\Http\Controllers\Auth;

use App\Frontuser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;

class FrontAuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Where to redirect users for login.
     *
     * @var string
     */
    protected $loginPath = '/login';

    /**
     * The guard used for managing customers.
     *
     * @var string
     */
    protected $guard = 'customer';
    
    public function __construct()
    {
        $this->middleware('front.guest', ['except' => ['getLogout']]);
    }
 
    public function getLogin()
    {
        
        $this->data['page_title'] = 'User Login';
        return view('front.auth.login')->with($this->data);
    }
    
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $messages = array(
            'g-recaptcha-response.required' => 'The recaptcha field is required.'
        );

        $validator = Validator::make($request->all(), [
            'user_name' =>'required', 
            'password' =>'required',
            'g-recaptcha-response' => 'required|captcha'
        ], $messages);
        
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            $credentials = array('user_name'=>$request->input('user_name'),'password'=>$request->input('password'));
            if (Auth::guard('customer')->attempt($credentials))
            {
                $user = Auth::guard('customer')->user();
                if ($user->deleted_at != NULL)
                {
                    Session::flash('error_flash_message', 'Your account has been destroyed.');
                    return $this->getLogout();
                }
                elseif ($user->status == 0)
                {
                    Session::flash('error_flash_message', 'Your account has not been activated.');
                    return $this->getLogout();
                }

                return redirect('dashboard');
            }
            else
            {
                Session::flash('error_flash_message', 'Incorrect username or password.');
                return redirect()->back();
            }
        }
    }

    public function getLogout()
    {
        Auth::guard('customer')->logout();
        return redirect('login');
    }
}
