<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Support\Facades\Auth;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = Auth::user(); // Retrieve the authenticated user

        // Check if the user is authenticated
        if ($user) {
            // Eager load the roles relationship
            $user->load('roles');
        } else {
            $user = null; // If user is not authenticated, set it to null
        }

        return array_merge(parent::share($request), [
            // 'user' => Auth::user()->load('roles') ?  : null,
            'user' => $user,
            

            'flash' => [
                'message' =>session('message'),
                'message_success' =>session('message_success'),
            ],

            
        ]);
    }
       
}
