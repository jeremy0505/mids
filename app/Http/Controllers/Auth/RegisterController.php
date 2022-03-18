<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\Account;
use App\Models\UserAccountAccess;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country' => ['required', 'string', 'min:2', 'max:2'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        
        // dd('0-' . str_pad('1',8,'0',STR_PAD_LEFT));


        $urec = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'country' => $data['country'],
            'password' => Hash::make($data['password']),
        ]);


        $uprec = UserPlan::create([
          'user_id' => $urec->id,
          'plan_id' => $data['plan_id'],
          'client_id' => '0',
        ]);

        // create the account and create access to the account

        $acctrec = Account::create([
          'account_owner_user_id' => $urec->id,
          'client_id' => '0',
          'account_code' => '0-' . str_pad($urec->id,8,'0',STR_PAD_LEFT),
        ]);

        $acctaccessrec = UserAccountAccess::create([
          'user_id' =>  $urec->id,
          'account_id' => $acctrec->account_id,
          'client_id' => 0,
          'date_granted' => now(),
          'access_mode' => 'OWNER',
        ]);

        return $urec;
    }
}
