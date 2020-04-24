<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name'     => ['required', 'string', 'max:50'],
                'email'    => ['required', 'email',  'max:40', 'unique:users'],
                'password' => ['required', 'string', 'between:8,60', 'confirmed'],
            ],
            [
                'required'  => 'A(z) :attribute értékét kötelező megadni!',
                'string'    => 'A(z) :attribute értékének karakterláncnak kell lennie!',
                'email'     => 'Érvénytelen e-mail cím!',
                'max'       => 'A(z) :attribute maximális hossza :max karakter lehet!',
                'between'   => 'A(z) :attribute hossza minimum :min és maximum :max karakter lehet!',
                'unique'    => 'Már létezik regisztráció a megadott e-mail címmel!',
                'confirmed' => 'A jelszavak nem egyeznek!',
            ],
            [
                'name'     => 'név',
                'email'    => 'e-mail cím',
                'password' => 'jelszó',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
