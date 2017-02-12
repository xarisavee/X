<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Illuminate\Support\MessageBag;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {
            return Redirect::route('home');
        }
        
        $actions = $request->route()->parameters();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;
        $domain = isset($actions['domain']) ? $actions['domain'] : null;

        if ($request->user()->hasAnyRole($roles, $domain) || !$roles) {
            return $next($request);
        }
        $errors = new MessageBag(['password' => ['Incorrect email/password. Please retry.']]);
        return Redirect::route('home')->withErrors($errors);
    }
}
