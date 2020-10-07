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
     * @param Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return wrapControllerAction(function() use ($request) {
            $searchParameters = [
                'user_id' => $request->input('user_id'),
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'limit' => $request->input('limit'),
                'offset' => $request->input('offset'),
            ];

            $searchResult = (new Post)->search($searchParameters);

            return response()->json(
                $searchResult['dataCollection'],
                200,
                ['X-Total-Count' => $searchResult['dataCount']]
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return wrapControllerAction(function() use ($request) {
            $this->validate($request, [
                'title' => ['required', 'string', 'alpha', 'max:255'],
                'body' => ['required', 'string', 'max:2000'],
                'user_id' => ['required', 'numeric'],
            ]);

            $post = Post::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'user_id' => $request->input('user_id'),
            ]);

            return response()->json($post, 201);
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
            $post = (new Post)->searchById($id);
            return response()->json($post, 200);
        });
    }
}
