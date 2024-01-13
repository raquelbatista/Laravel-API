<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Models\Posts;
use App\Models\Users;
use Illuminate\Support\Facades\Http;

class PostsController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/posts');

            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch data from the external API'], $response->status());
            }

            $data = $response->json();
            foreach ($data as $item) {
                $userId = $item['userId'];
                $user = Users::find($userId);

                $user->posts()->create([
                    'title' => $item['title'],
                    'body' => $item['body'],
                ]);

            }
            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store(PostsRequest $request)
    {
        try{
            $data = $request->all();
            $validated = $request->validated();

            $user = Users::find($data['users_id']);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $posts = Posts::create($data);
            return response()->json(['message' => 'Posts created successfully', 'Posts' => $posts]);
        }catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = Posts::find($id);

            if (!$post) {
                return response()->json(['error' => 'Posts not found'], 404);
            }

            return response()->json(['message' => 'Posts details retrieved successfully', 'posts' => $post]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update(PostsRequest $request, $id)
    {
        try {
            $post = Posts::find($id);

            if (!$post) {
                return response()->json(['error' => 'Posts not found'], 404);
            }

            $requestData = $request->all();
            $validated = $request->validated();
            $post->update($requestData);

            return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Posts::find($id);

            if (!$post) {
                return response()->json(['error' => 'Posts not found'], 404);
            }

            $post->delete();
            return response()->json(['message' => 'Post deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
