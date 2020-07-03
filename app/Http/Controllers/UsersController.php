<?php

namespace App\Http\Controllers;

use App\Models\ApiResponse;
use App\Models\Users\UsersRepository;
use App\Models\Users\Users;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UsersRepository();
    }

    public function index()
    {
        try {

            return ApiResponse::success($this->userRepository->getUsers());
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show($id)
    {
        try {

            return ApiResponse::success($this->userRepository->getUserById((int)$id)
                ->toArray());
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $users = Users::factory($request->toArray());
            if (!empty($users->getErrors())) {
                return ApiResponse::errorValidation($users->getErrors());
            }
            $userRepository = new UsersRepository($users->toArray());
            $userRepository->save();

            return ApiResponse::success(['id' => $userRepository->getQueueableId()],
                "user save successfully");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $user = $this->userRepository->getUserById((int)$id);
            if (empty($user)) {
                return ApiResponse::errorValidation(["the user doesn't exist"]);
            }
            $usersIns = Users::update($request->toArray());
            if (!empty($usersIns->getErrors())) {
                return ApiResponse::errorValidation($usersIns->getErrors());
            }
            $user->updateData($usersIns);

            return ApiResponse::success($request->toArray(),
                "user save successfully");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }


    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepository->getUserById((int)$id);
            if (empty($user)) {
                return ApiResponse::errorValidation(["the user doesn't exist"]);
            }
            $user->delete();

            return ApiResponse::success(['id' => $id],
                "the user delete successfully");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}
