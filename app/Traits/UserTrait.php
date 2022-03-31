<?php 

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\User;
use App\UserRole;

trait UserTrait
{
    // Create user account 
    public function createUser(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $user;
    }

    // Create user role upon registration
    // Accepts user_id and role_id (int) from respective regristation request
    public function createUserRole($user_id, $role_id) {
        $userRole = UserRole::create(['user_id' => $user_id, 'role_id' => $role_id]);
        return $userRole;
    }

    // Creates verification token to user
    // Accepts user_role_id
    public function createVerificationToken($user_role_id) {
        $rand = str_random(10);
        $verificationRoken = hash('sha256', $user_role_id.$rand);
        return $verificationRoken;
    }

    // Save verification token to user
    public function saveUserVerificationToken($user_id, $token) {
        User::where('id', $user_id)
            ->update(['verification_token' => $token]);
    }

    // Verify user from email url 
    public function verifyUserByToken($token) {
        $user = User::where('verification_token', $token)->first();
        if($user) {
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->verification_token = null;

            if($user->save()){
                return view('site.email-verified', ['user' => $user]);
            }
        } else {
            return response()->view('errors.404', [], 500);
        }
    }

    // Get logged in user details
    public function getUser() {
        return User::where('id', auth()->user()->id)->with('role')->first();
    }

    // Get user by verification token
    public function getUserByToken($token) {
        $user = User::where('verification_token', $token)->with('jobseeker')->first();

        return $user;
    }

    // Remove auth_refresh_token during user logout
    public function removeRefreshToken($token_id) {
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $token_id)
            ->delete();
    }
}