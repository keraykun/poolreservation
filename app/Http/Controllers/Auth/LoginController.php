<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Rules\StartsWith09And11Digits;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('home.login.index');
    }

    public function register(){
        return view('home.login.register');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>['required','min:4'],
            'email'=>['required','min:4','unique:users,email'],
            'password' =>['required','min:4','confirmed'],
            'contact' => ['required', 'string', new StartsWith09And11Digits()],
        ]);

       $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>'user',
            'contact'=>$request->contact,
            'password'=>$request->password
        ]);
        Auth::login($user);
        return redirect()->route('home.bookings.index');
    }


    public function login(Request $request)
    {

        $account = User::where('email',$request->email)->where('active',0)->first();
        if($account){
            return redirect()->route('guest.login')
            ->with('error','This account has been terminated, please contact us!');
        }

        config(['app.timezone' => 'Asia/Manila']);

        $input = $request->all();

        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);


        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {

            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard.index');
                case 'user':
                    return redirect()->route('home.bookings.index');
                case 'employee':
                    // try {
                    //     $user = Auth::user();
                    //     activity()
                    //         ->performedOn($user)
                    //         ->causedBy($user)
                    //         ->inLog($user->email)
                    //         ->withProperties([
                    //             'Login' =>Carbon::now(),
                    //         ])
                    //         ->event('login')
                    //         ->log('The '.$user->name.' has been login');
                    // } catch (\Exception $e) {
                    //     \Log::error('Error logging activity: ' . $e->getMessage());
                    //     \Log::error($e);
                    // }
                    return redirect()->route('employee.dashboard.index');
                default:
                    abort(403);
            }
        }else{
                return redirect()->route('guest.login')
                ->with('error','Email and Password Invalid. Please try again!');
        }

    }

    public function logout(){

        // $user = Auth::user();
        // if($user->role=='employee'){
        //         activity()
        //         ->performedOn($user)
        //         ->causedBy($user)
        //         ->inLog($user->email)
        //         ->withProperties([
        //             'Logout' =>Carbon::now(),
        //         ])

        //         ->event('logout')
        //         ->log('The ' . $user->name . ' has been logged out');
        // }
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
