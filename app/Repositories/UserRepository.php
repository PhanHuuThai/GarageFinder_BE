<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function getUserByEmail($email) {
        return $this->model->where('email', $email)->first();
    }

    public function storeUser($userRequest) {
        try {
            $user = new $this->model;
            $user->email = $userRequest->email;
            $user->username = $userRequest->email;
            $user->password = Hash::make($userRequest->password);
            $user->id_provider = 2;
            $user->id_role = 1;
            $user->save();
            return $user;
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

    public function updateUser($userRequest)
    {
        try {
            $userRequest->save();
            return $userRequest;
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

}