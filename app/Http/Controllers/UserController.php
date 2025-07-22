<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DataHandleService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $dataHandleService;

    public function __construct(DataHandleService $dataHandleService)
    {
        $this->dataHandleService = $dataHandleService;
    }
    public function index(Request $request)
    {
        $paging = $request->perPage ?? 10;

        $users = User::select('id', 'name', 'email', 'role')
                     ->latest()
                     ->paginate($paging);
        return response()->json([
            'data' => $users->items(), 
            'currentPage' => $users->currentPage(),
            'totalPages' => $users->lastPage(),
        ]); 
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $this->doValidate($request);
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = $this->dataHandleService->store(new User(), $data);
        if ($user) {
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
        }
        return response()->json([
            'message' => 'Failed to create user',
        ], 400);
    }
    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }
    public function update(Request $request, User $user)
    {
        $this->doValidate($request, $user->id);
        $data = $request->all();
        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $updatedUser = $this->dataHandleService->store($user, $data);
        if ($updatedUser) {
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $updatedUser,
            ]);
        }
        return response()->json([
            'message' => 'Failed to update user',
        ], 400);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'user deleted successfully'], 200);
    }
    protected function doValidate(Request $request, $userId = null)
    {
        $uniqueEmailRule = 'unique:users,email';
        if ($userId) {
            $uniqueEmailRule .= ',' . $userId;
        }
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', $uniqueEmailRule],
            'phone' => 'nullable|string|max:20',
            'password' => $userId ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:admin,developer',
        ]);
    }
}
