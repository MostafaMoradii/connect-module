<?php

namespace Visiosoft\ConnectModule\Http\Middleware;

use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class SetLastActivityMiddleware
{
    protected $redirect;

    protected $userRepository;

    public function __construct(
        Redirector              $redirect,
        UserRepositoryInterface $userRepository
    )
    {
        $this->redirect = $redirect;
        $this->userRepository = $userRepository;
    }

    public function handle(Request $request, Closure $next)
    {

        if (!empty($request->header('authorization')) && !empty(Auth::id())) {
            if ($user = $this->userRepository->find(Auth::id())) {
                $user->update(['last_activity_at' => Carbon::now()]);
            }
        }

        return $next($request);
    }
}