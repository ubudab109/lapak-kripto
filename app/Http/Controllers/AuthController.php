<?php

namespace App\Http\Controllers;

use App\Http\Requests\g2fverifyRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetPasswordSaveRequest;
use App\Model\AffiliationCode;
use App\Model\Referral;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    //login
    public function login()
    {
        if (Auth::user()) {
            if (Auth::user()->role == USER_ROLE_SUPERADMIN || Auth::user()->role == USER_ROLE_ADMIN) {
                return redirect()->route('adminDashboard');
            } elseif (Auth::user()->role == USER_ROLE_USER) {
                return redirect()->route('userDashboard');
            } else {
                Auth::logout();
                return view('auth.login');
            }
        }
        return view('auth.login');
    }

    // sign up
    public function signUp()
    {
        return view('auth.signup');
    }

    // resend verification
    public function resendVerification()
    {
        return view('auth.resend-verifiy-email');
    }

    // forgot password
    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    // forgot password
    public function resetPasswordPage()
    {
        return view('auth.reset_password');
    }

    // sign up process with referral sign up
    public function signUpProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' =>[
                'required',
                // 'strong_pass',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'password_confirmation' => 'required|min:8|same:password',
            'g-recaptcha-response' => 'required',
        ], [
            'first_name' => __('First name can not be empty'),
            'phone.required' => __('Phone number name can not be empty'),
            'phone.numeric' => __('Please enter a valid phone number'),
            'last_name' => __('Last name can not be empty'),
            'device_token.required' => __('Device token field can not be empty'),
            'device_type.required' => __('device type field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password_confirmation.required' => __('Confirm Password field can not be empty'),
            'password.min' => __('Password length must be atleast 8 characters.'),
            'password.regex' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            // 'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'password_confirmation.min' => __('Confirm Password length must be atleast 8 characters.'),
            'password_confirmation.same' => __('Password and confirm password doesn\'t match'),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email Address already exists'),
            'email.email' => __('Invalid email address'),
            'g-recaptcha-response.required' => __('Please Pass Captcha'),
        ]);

        if ($validator->fails()) {
            return redirect()->route('signUp')->withInput()->with('dismiss', $validator->errors()->first());
        }

        DB::beginTransaction();
        $parentUserId = 0;
        try {
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->route('signUp')->withInput()->with('dismiss', __('Invalid email address'));
            }
            if ($request->has('ref_code')) {
                $parentUser = AffiliationCode::where('code', $request->ref_code)->first();
                if (!$parentUser) {
                    return ['status' => false, 'message' => __('Invalid referral code.')];
                } else {
                    $parentUserId = $parentUser->user_id;
                }
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => __('Failed to signup! Try Again.' . $e->getMessage())];
        }
        try {
            $mail_key = $this->generate_email_verification_key();
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => USER_ROLE_USER,
                'password' => Hash::make($request->password),
            ]);
            UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);

            Wallet::create([
                'user_id' => $user->id,
                'name' => 'DOLLAR',
                'is_primary' => STATUS_SUCCESS,
            ]);
            if ($parentUserId > 0) {
                $referralRepository = app(AffiliateRepository::class);
                $referralRepository->createReferralUser($user->id, $parentUserId);
            }
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
        }
        if (!empty($user)){
            $this->sendVerifyemail($user, $mail_key);
            return redirect()->route('login')->with('success',__('Email send successful,please verify your email'));

        } else {
            return redirect()->route('signUp')->with('dismiss',__('Something went wrong'));
        }
    }

    private function generate_email_verification_key()
    {
        $key = randomNumber(6);
        return $key;
    }

    // login process
    public function loginProcess(LoginRequest $request)
    {
        $data['success'] = false;
        $data['message'] = '';
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            if(empty($user->email_verified_at))
                $user->email_verified_at =  0;

            if(($user->role == USER_ROLE_USER) || ($user->role == USER_ROLE_SUPERADMIN) || ($user->role == USER_ROLE_ADMIN)) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    //Check email verification
                    if ($user->status == STATUS_SUCCESS) {
                        if (!empty($user->is_verified)) {
                            $data['success'] = true;
                            $data['message'] = __('Login successful');
                            //  return redirect()->back()->with('success',$data['message']);
                            if (Auth::user()->role == USER_ROLE_SUPERADMIN || Auth::user()->role == USER_ROLE_ADMIN) {
                                return redirect()->route('adminDashboard')->with('success',$data['message']);
                            } else {
                                createUserActivity(Auth::user()->id, USER_ACTIVITY_LOGIN);
                                return redirect()->route('userDashboard')->with('success',$data['message']);
                            }
                        } else {
                            $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                                ->where('user_verification_codes.user_id',$user->id)
                                ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                                ->first();
                            if(!empty($existsToken)) {
                                $mail_key = $existsToken->code;
                            } else {
                                $mail_key = randomNumber(6);
                                UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'status' => STATUS_PENDING, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
                            }
                            try {
                                $this->sendVerifyemail($user, $mail_key);
                                $data['success'] = false;
                                $data['message'] = __('Your email is not verified yet. Please verify your mail.');
                                Auth::logout();

                                return redirect()->route('login')->with('dismiss',$data['message']);
                            } catch (\Exception $e) {
                                $data['success'] = false;
                                $data['message'] = $e->getMessage();
                                Auth::logout();

                                return redirect()->route('login')->with('dismiss',$data['message']);
                            }
                        }
                    } elseif ($user->status == STATUS_SUSPENDED) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been suspended. please contact support team to active again");
                        Auth::logout();
                        return redirect()->route('login')->with('dismiss',$data['message']);
                    } elseif ($user->status == STATUS_DELETED) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been deleted. please contact support team to active again");
                        Auth::logout();
                        return redirect()->route('login')->with('dismiss',$data['message']);
                    } elseif ($user->status == STATUS_PENDING) {
                        $data['success'] = false;
                        $data['message'] = __("Your account has been pending for admin approval. please contact support team to active again");
                        Auth::logout();
                        return redirect()->route('login')->with('dismiss',$data['message']);
                    }

                } else {
                    $data['success'] = false;
                    $data['message'] = __("Email or Password doesn't match");
                    return redirect()->route('login')->with('dismiss',$data['message']);
                }
            } else {
                $data['success'] = false;
                $data['message'] = __("You have no login access");
                Auth::logout();
                return redirect()->route('login')->with('dismiss',$data['message']);
            }
        } else {
            $data['success'] = false;
            $data['message'] = __("You have no account,please register new account");
            return redirect()->route('login')->with('dismiss',$data['message']);
        }
    }

    // send verify email
    public function sendVerifyemail($user, $mail_key)
    {
        $mailService = new MailService();
        $userName = $user->first_name.' '.$user->last_name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send('email.verifyWeb', $data, $userEmail, $userName, $subject);
        dd($mailService);
    }

    // send token

    public function sendForgotMail(Request $request)
    {
        $rules = ['email' => 'required|email','g-recaptcha-response' => 'required'];
        $messages = ['email.required' => __('Email field can not be empty'), 'email.email' => __('Email is invalid'),'g-recaptcha-response.required' => __('Please Pass Captcha')];
        $request->validate($rules,$messages);
        $user = User::where(['email' => $request->email])->first();

        if ($user) {
            DB::beginTransaction();
            try {
                $key = randomNumber(6);
                $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                    ->where('user_verification_codes.user_id',$user->id)
                    ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                    ->first();
                if(!empty($existsToken)) {
                    $token = $existsToken->code;
                } else {
                    UserVerificationCode::create(['user_id' => $user->id, 'code'=>$key,'expired_at' => date('Y-m-d', strtotime('+15 days')), 'status' => STATUS_PENDING]);
                    $token = $key;
                }

                $user_data = [
                    'user' => $user,
                    'token' => $token,
                ];

                $mailService = new MailService();
                $userName = $user->first_name.' '.$user->last_name;
                $userEmail = $user->email;
                $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Company Name');
                $subject = __('Forgot Password | :companyName', ['companyName' => $companyName]);
                $mailService->send('email.password_reset', $user_data, $userEmail, $userName, $subject);

                $data['message'] = 'Mail sent successfully to ' . $user->email . ' with password reset code.';
                $data['success'] = true;
                Session::put(['resend_email'=>$user->email]);
                DB::commit();

                return redirect(route('resetPasswordPage'))->with('success',$data['message']);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('dismiss', __('Something went wrong. Please check mail credential.'));
            }

        } else {
            return redirect()->back()->with('dismiss',__('Email not found'));
        }
    }

    // logout
    public function logOut()
    {
        Session::forget('g2f_checked');
        Session::flush();
        Auth::logout();
        return redirect()->route('logOut')->with('success', __('Logout successful'));
    }

    // reset password save process

    public function resetPasswordSave(ResetPasswordSaveRequest $request)
    {
        try {
            $vf_code = UserVerificationCode::where(['code' => $request->token, 'status' => STATUS_PENDING])->first();

            if (!empty($vf_code)) {
                $user = User::where(['id'=> $vf_code->user_id, 'email'=>$request->email])->first();
                if (empty($user)) {
                    return redirect()->back()->withInput()->with('dismiss', __('User not found'));
                }
                $data_ins['password'] = hash::make($request->password);
                $data_ins['is_verified'] = STATUS_SUCCESS;
                if(!Hash::check($request->password,User::find($vf_code->user_id)->password)) {

                    User::where(['id' => $vf_code->user_id])->update($data_ins);
                    UserVerificationCode::where(['id' => $vf_code->id])->delete();

                    $data['success'] = 'success';
                    $data['message'] = __('Password Reset Successfully');
                } else {
                    $data['success'] = 'dismiss';
                    $data['message'] = __('You already used this password');
                    return redirect()->back()->with($data['success'],$data['message']);
                }

            } else {
                $data['success'] = 'dismiss';
                $data['message'] = __('Invalid code');

                return redirect()->back()->with('dismiss', __('Invalid code'));
            }
            return redirect()->route('login')->with($data['success'],$data['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    // 2 fa check page
    public function g2fChecked(Request $request)
    {
        return view('auth.g2f');
    }

    // g2fa verification
    public function g2fVerify(g2fverifyRequest $request){

        $google2fa = new Google2FA();
        $google2fa->setAllowInsecureCallToGoogleApis(true);
        $valid = $google2fa->verifyKey(Auth::user()->google2fa_secret, $request->code, 8);

        if ($valid){
            Session::put('g2f_checked',true);
            return redirect()->route('userDashboard')->with('success',__('Login successful'));
        }
        return redirect()->back()->with('dismiss',__('Code doesn\'t match'));

    }

    // post resend verification email
    public function resendEmailVerification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'g-recaptcha-response' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('resendVerification')->withInput()->with('dismiss', $validator->errors()->first());
            }
            $user = User::where(['email' => $request->email])->first();
            $mail_key = $this->generate_email_verification_key();
            if (!empty($user)){
                $this->sendVerifyemail($user, $mail_key);
                return redirect()->route('login')->with('success',__('Email send successful,please verify your email'));
    
            } else {
                return redirect()->route('resendVerification')->with('dismiss',__('Email doesn\'t exists '));
            }
        } catch (\Exception $err) {
            dd($err);
        }
    }
    // verify email
    //
    public function verifyEmailPost(Request $request)
    {
        
        $user = User::where(['email' => $request->email])->first();
        if (!empty($user)) {
            $varify = UserVerificationCode::where(['user_id' => $user->id])
                ->where('code', decrypt($request->token))
                ->where('status', STATUS_PENDING)
                ->whereDate('expired_at', '>', Carbon::now()->format('Y-m-d'))
                ->first();

            if ($varify) {
                $check = $user->update(['is_verified' => STATUS_SUCCESS]);
                try {
                    if ($check) {
                        UserVerificationCode::where(['user_id' => $user->id])->delete();
                        return redirect()->route('login')->with('success',__('Verify successful,you can login now'));
                    }
                } catch (\Exception $e) {

                }
            } else {
                Auth::logout();
                return redirect()->route('login')->with('dismiss',__('Your verify token was expired,you can generate new token'));
            }
        }
    }
}
