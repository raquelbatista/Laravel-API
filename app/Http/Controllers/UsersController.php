<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Models\Users;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    //GET USERS AND SUBMIT DATABASE
    public function index()
    {
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/users');

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data as $item) {
                    Users::create([
                        'name' => $item['name'],
                        'username' => $item['username'],
                        'email' => $item['email'],
                        'city' => $item['address']['city'],
                        'zipcode' => substr($item['address']['zipcode'], 0, 255),
                        'phone' => $item['phone'],
                        'website' => $item['website'],
                    ]);
                }

                return response()->json(['message' => 'Data fetched and saved successfully']);
            } else {
                return response()->json(['error' => 'Failed to fetch data from the external API'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    //INSERT USERS
    public function store(UsersRequest $request){
        try{
            $data = $request->all();
            $user = Users::create($data);
            return response()->json(['message' => 'User created successfully', 'user' => $user]);
        }catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    //SHOW DETAILS USERS
    public function show($id)
    {
        try{
            $user = Users::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json(['message' => 'User details retrieved successfully', 'user' => $user]);
        }catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    //EDIT USERS
    public function update(UsersRequest $request, $id)
    {
        try{
            $user = Users::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $requestData = $request->all();
            $validated = $request->validated();

            $user->update($requestData);
            Log::info('User editado', ['id' =>$user->id]);
            return response()->json(['message' => 'User updated successfully', 'user' => $user]);
        }catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    //DELETE USERS
    public function destroy($id){
        try{
            $response = Users::find($id);

            if (!$response) {
                return response()->json(['error' => 'Failed to fetch data from the external API']);
            }

            $response->delete();
            return response()->json(['message' => 'Data fetched and delete successfully']);
        }catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
