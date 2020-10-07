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

            $user = User::create([ // TODO: implement within the model.
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

            return response()->json($user, 201);
        });
    }
}
