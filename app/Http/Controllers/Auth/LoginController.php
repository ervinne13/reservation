<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @override
     * @return string
     */
    public function username() {
        return 'username';
    }

    /**
     * Get the post register / login redirect path.
     * @Override
     * @return string
     */
    public function redirectPath() {

        $authenticatedUser = Auth::user();

        if ($authenticatedUser->role_name == User::ROLE_ADMIN) {
            return "/";
        } else {
            return "/reservations";
        }
    }

}
