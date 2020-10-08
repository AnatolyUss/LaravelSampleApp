<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return wrapControllerAction(function() use ($request) {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email'],
            ]);

            $user = (new User)->createUser([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
            ]);

            return response()->json($user, 201);
        });
    }
}
