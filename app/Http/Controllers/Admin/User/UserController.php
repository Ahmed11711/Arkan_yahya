<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
 use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Login\LoginResource;
use App\Http\Requests\Auth\UpdateRegisterRequest;

class UserController extends Controller
{
     
    public function index(Request $request)
{
    $query = User::query();

    if ($request->has('type')) {
        $query->where('type', $request->type); // خليه ديناميكي مش ثابت على user
    }

    $users = $query->get(); // 👈 نفّذ الكويري هنا

    return LoginResource::collection($users);
}

   
    public function store(RegisterRequest $request)
    {
         $data = $request->validated();

         $data['password'] = bcrypt($data['password']);

         $user = User::create($data);

        return new LoginResource($user);
    }

  
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return new LoginResource($user);
    }

     
    public function update(UpdateRegisterRequest $request, string $id)
    {
        $data=$request->validated();
        $user = User::findOrFail($id);


         if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); 
        }
     Log::info("ss",[$data]);

        $user->update($data);

        return new LoginResource($user);
    }

    
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
