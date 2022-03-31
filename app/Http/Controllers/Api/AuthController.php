<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\UserTrait;
use App\Jobs\SendVerificationEmail;

class AuthController extends Controller
{
    use UserTrait;
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Check Job Seeker or Employer Account Creation
        switch($request->type) {
            case 'Job Seeker':
                $this->validate($request, [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed',
                ]);

                $request['name'] = $request->first_name.' '.$request->last_name;
                $user = $this->createUser($request);

                // Create Job Seeker Account
                $request['user_id'] = $user->id;
                $createJobseeker = $this->createJobSeeker($request);

                // Create access token
                $createUserRole = $this->createUserRole($user->id, 3);

                // Create verification token
                $verificationToken = $this->createVerificationToken($createUserRole->id);

                // Update user verification token value
                $saveVerificationToken = $this->saveUserVerificationToken($user->id, $verificationToken);

                // Email user veification url with token
                dispatch(new SendVerificationEmail($user));

                return response()->json(['success' => "Success! We've sent you and email to verify your account."], 200);

            break;

            case 'Employer':
                $this->validate($request, [
                    'company_name' => 'required',
                    'full_name' => 'required',
                    'designation' => 'required',
                    'department' => 'required',
                    'phone_number' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed',
                ]);

                $request['name'] = $request->full_name;
                $user = $this->createUser($request);

                // Create Employer Account
                // Code Here

                // Create access token
                $createUserRole = $this->createUserRole($user->id, 2);

                // Create verification token
                $verificationToken = $this->createVerificationToken($createUserRole->id);

                // Update user verification token value
                $saveVerificationToken = $this->saveUserVerificationToken($user->id, $verificationToken);

                // Email user veification url with token
                dispatch(new SendVerificationEmail($user));

                return response()->json(['success' => "Success! We've sent you and email to verify your account."], 200);
            break;

            default:
                return response()->json(['error' => 'Unauthorized Access'], 401);
        }
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];
    
            if (auth()->attempt($credentials)) {
                // Check if user email is verified
                if(auth()->user()->email_verified_at) {
                   
                    // Login and grant access token to user
                    $response = $http->post(config('services.passport.login_endpoint'), [
                        'form_params' => [
                            'grant_type' => 'password',
                            'client_id' => config('services.passport.client_id'),
                            'client_secret' => config('services.passport.client_secret'),
                            'username' => $request->email,
                            'password' => $request->password,
                        ]
                    ]);
                    $token = json_decode($response->getBody(), true);
                    // return $response->getBody();
                    // dd($response->getBody());
                    return response()->json([
                        'user' => $this->getUser(),
                        'auth' => $token
                    ], 200);
                    
                } else {
                    return response()->json(['info' => 'Please verify your email address first.'], 200);
                }
            } else {
                return response()->json(['error' => 'These credentials do not match our records.'], 200);
            }
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => $this->getUser()], 200);
        // return response()->json(['user' => auth()->user()->getRoleSlugAttribute()], 200);
    }

    /**
     * Logouts User details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout (Request $request) {

        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();

            // Delete refresh token
            $this->removeRefreshToken($token->id);
        });

        return response()->json('Logged out successfully', 200);
    
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        return redirect('job-seeker-details/'.$token);
    }

    /**
     * Get user details using verification token, used for updating job seeker details for the first time/on boarding process
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function getUserOnBoarding(Request $request)
    {
        return $this->getUserByToken($request->token);
    }
}
