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

    /**
     * Display the specified resource.
     *
     * @param Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        return wrapControllerAction(function() use ($request, $id) {
            // !!!Notice, the $id is validated by Laravel automatically.
            $post = (new User)->searchById($id);
            return response()->json($post, 200);
        });
    }
}
