<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show1(){
        return view('#1');
    }

    public function store1(Request $request){
        $this->validator1($request->all())->validate();
     session([
        'register.email' => $request->email,
        'register.password' => Hash::make($request->password),
     ]);
     return redirect()->route('register.show2');
    }

    public function show2(){
        return view('#2');
    }
    public function store2(Request $request){
        $this->validator2($request->all())->validate();

        $user = $this->create([
            'email' => session('register.email'),
            'password' => session('register.password'),
            'name' => $request->name,
            'target_language' => $request->target_language,
            'birthday' => $request->birthday,
            'country' => $request->country,
            'region' => $request->region,
        ]);

        session()->forget('register');
        $this->guard()->login($user);
        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator1(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    protected function validator2(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'target_language' => ['required', 'string'],
            'birthday' => ['required', 'date'],
            'county' => ['required', 'string'],
            'region' => ['required', 'string'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'target_language' => $data['target_language'],
            'birthday' => $data['birthday'],
            'country' => $data['country'],
            'region' => $data['region'],
        ]);
    }


}
