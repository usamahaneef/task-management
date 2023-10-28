<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\StudentForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function signup(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'unique:users',
            'university_id' => 'required|exists:universities,id',
            'password' => 'required|confirmed',        
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->university_id = $request->input('university_id');
        $user->password = Hash::make($request->password);
        $user->api_token = Str::random(60);
        $user->save();

        return response()->json([
            'response' => 101,
            'message' => 'Student registered successfully',
            'validation_errors' => null,
            'data' => $user
        ]);
    }

     public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',        
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }

        $user = User::where('email' , $request->email)->first();
        $passwordRecoveryToken = rand(100000, 999999);
        $user->password_recovery_token = $passwordRecoveryToken;
        $user->save();

        $details = [
            'title' => 'Forgot Your Password',
            'name' => $user->name,
            'token' => $user->password_recovery_token,
            'email' => $user->email,
        ];
        Mail::to($request->email)->send(new StudentForgotPasswordMail($details));

        return response()->json([
            'response' => 101,
            'message' => 'Your Recovery otp send successfully check email',
        ]);
    
    }

    public function otpVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'email' => 'required|exists:users,email',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }

        $user = User::where('email' , $request->email)
            ->where('password_recovery_token', $request->otp)
            ->first();

        if ($user) {
            return response()->json([
                'response' => 101,
                'message' => 'Otp verified successfully',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'response' => 100,
                'message' => 'Invalid OTP you entered.',
            ]);
        }

    }
    

     public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|confirmed', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }

        $user = User::where('email' , $request->email)->first();

        if ($user) {
            $user->password_recovery_token = null;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->loadMissing('university');
        
            if (!$user->api_token) {
                $user->api_token = Str::random(60);
                $user->save();
            }
        
            return response()->json([
                'response' => 101,
                'message' => 'Reset Password successfully',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'response' => 100,
                'message' => 'Invalid email you entered.',
            ]);
        }
    }
    
    
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }
        
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $user->loadMissing('university');
        
            if (!$user->api_token) {
                $user->api_token = Str::random(60);
                $user->save();
            }
        
            return response()->json([
                'response' => 101,
                'message' => 'Student logged in successfully',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'response' => 100,
                'message' => 'Invalid email or password.',
            ]);
        }
        
    }
    public function profile(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'profile' => 'nullable|image',
        ], [
            'profile.image' => 'Image must be a valid image file'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }

        $user = User::find($id);
        if ($request->hasFile('profile')) {
            $media = $user->addMediaFromRequest('profile')->toMediaCollection('student_profile_image');
        }else {
            return response()->json([
                'response' => 103,
                'message' => 'Student Profile Not Updated',
                'validation_errors' => null,
                'data' => $user
            ]);
        }
        $user->refresh();
        return response()->json([
            'response' => 101,
            'message' => 'Student Profile Uploaded Successfully',
            'validation_errors' => null,
            'data' => $user
        ]);
        
    }

    public function updatePassword(Request $request , $id)
    {
        $user = User::find($id);

        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {
                $validator = Validator::make($request->all(), [
                    'new_password' => 'required|min:8',
                    'confirm_new_password' => 'required|same:new_password'
                ]);
        
                if ($validator->fails()) {
                    return response()->json([
                        'response' => 102,
                        'message' => 'Bad Request',
                        'validation_errors' => $validator->errors(),
                        'data' => null
                    ]);
                }

                $user->password = Hash::make($request->new_password);
                $user->save();
                $user->loadMissing('university');
        
                return response()->json([
                    'response' => 101,
                    'message' => 'Update Password successfully',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'response' => 103, 
                    'message' => 'Current password is incorrect.',
                ]);
            }
        } else {
            return response()->json([
                'response' => 100,
                'message' => 'Invalid User.',
            ]);
        }
        
        
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'response' => 103,
                'message' => 'User not found',
                'data' => null
            ]);
        }
    
        $user->sendEmailVerificationNotification();
    
        return response()->json([
            'response' => 101,
            'message' => 'Email verification link sent successfully',
            'data' => $user
        ]);
    }
    
    
    public function verify(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:users,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null
            ]);
        }

        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'response' => 103,
                'message' => 'User not found',
                'data' => null
            ]);
        }
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
    
            return view('emails.email-verification');
        } else {
            return response()->json([
                'response' => 104,
                'message' => 'Email already verified',
                'data' => null
            ]);
        }
    }

    public function deleteMyAccount(Request $request)
    {
        $dealer = auth('user_api')->user();
        $dealer->deletion_request_received_at = now();
        $dealer->save();

        return response()->json([
            'response' => 101,
            'message' => 'Your account deletion request has been submitted and put to review',
            'data' => null
        ]);
    }
    

    public function logout(Request $request)
    {

        $dealer = auth('user_api')->user();
        $dealer->api_token = null;
        $dealer->save();

        return response()->json(['message' => 'You are successfully logged out']);
    }
}
