<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return wrapControllerAction(function() use ($id) {
            // TODO: get current request instance.
            // TODO: upgrade validation code below.
//            $this->validate($request, [
//                'id' => ['required', 'numeric', 'integer'],
//            ]);

            $user = Post::searchById($id);

            return response()->json($user, 200);
        });
    }
}
