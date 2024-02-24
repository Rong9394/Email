<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class RegistrationController extends Controller {

    /**
     * @throws Exception
     */
    public function register(Request $request): JsonResponse {
        $user = new User();
        $user->name = $request->string('name');
        $user->email = $request->string('email');
        $user->password = $request->string('password');
        $user->email_verification_token = bin2hex(random_bytes(32)); // TODO
        $user->save();

        Notification::send($user, new NewUserRegisteredNotification());
        return response()->json(['registered' => $user]);
    }

    /**
     * @throws Exception
     */
    public function verifyEmail(Request $request): JsonResponse {
        $email = $request->input('email');
        $token = $request->input('token');
        $user = User::firstWhere('email', $email);
        if($user->email_verification_token === $token) {
            $user->email_verification_token = null;
            $date = Carbon::now();
            $user->email_verified_at = $date;
            $user->save();
            return response()->json(['verified' => $user]);
        }
        return response()->json(['error' => 'unsuccessful']);
    }

}
