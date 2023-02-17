<?php
namespace App\Http\Controllers\UserControl;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

//use Carbon\Carbon;
use App\User;
use App\Mail\MIGEmail;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        /* $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]); */
		
		if (Auth::attempt(['email' => request('username'), 'password' => request('password')]) || 
			Auth::attempt(['nik' => request('username'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $data['nik'] =  $user->nik;
            $data['name'] =  $user->name;
            $data['email'] =  $user->email;
            $data['position_id'] =  $user->position_id;
			$data['position_name'] =  $user->position['name'];
            $data['division_id'] =  $user->division_id;
            $data['division_name'] =  $user->division['name'];
            $data['photo'] =  $user->photo;
            $data['role_id'] =  $user->roles[0]->id;
            $data['role_name'] =  $user->roles[0]->name;
            $data['permission'] =  $user->getAllPermissions();
            $data['token'] =  $user->createToken('Laravel Personal Access Token')-> accessToken; 
            return response()->json(['success' => true, 'message' => 'Berhasil login', 'user' => $data], 200); 
        } 
        else{ 
            return response()->json(['success' => false, 'message' => 'Username atau Password tidak valid'], 200); 
        } 
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function forgot()
    {
        return view('auth/forgot');
    }
	
	public function got_new_pass(Request $request){
        
        $email = $request->email_Address;		
        $user = User::where('email', $email)->first();			
		
        if($user == null || $user == ""){
            return redirect()->route('forgot')->withErrors(['msg'=>"Email not registered!" ]);
        }else{                       
            $new_pass = "mig123!";
            
			//update new password
            $update_pass = User::where('id', $user->id)->update([
                "password" => bcrypt($new_pass)
            ]);            

            if($update_pass){
                $message = "[".$email. "] telah melakukan request forgot password <a href=" . route('login') . ">klik disini </a> untuk melakukan login <br>
                            Password baru anda : ".$new_pass."<br> Segera ganti password anda setelah login.";
                Mail::to($email)->send(new MIGEmail('[Account Information | MIG-IS] - Reset User Password', $message));
                return redirect()->route('login');
            }                        
        }        
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}