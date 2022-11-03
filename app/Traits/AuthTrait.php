<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

trait AuthTrait
{
    public function handleLoginMethod(Request $request): array
    {
        $request->validate($this->rulesLogin());
        abort_unless(auth()->attempt($request->only('email', 'password')),
            Response::HTTP_FORBIDDEN,'Invalid credentials');
        $token = Auth::user()->createToken('authToken');
        return $this->returnDataUser(Auth::user(), $token);
    }

    private function returnDataUser($user, $token): array
    {
        return [
            'user' => $user,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
        ];
    }

    protected function rulesLogin(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function handleLogoutMethod(Request $request): string
    {
        $request->user()->token()->revoke();
        return 'Logout successfully';
    }

}
