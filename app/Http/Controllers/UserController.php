<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;

class UserController extends AuthController
{
    //

    public function index(UserRequest $request) {
        return $this->response(User::all(), 200);

    }

    public function store(UserRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try{
            $user = new User($data);
            if (!empty($data['password']) && !empty($data['confirm_password'])) {
                if ($data['password'] == $data['confirm_password']) {
                    $user->setPassword($data['password']);
                }
                else {
                    throw new \Exception(["message" => "Password and confirm password must match."]);
                }
            }
            $user->save();
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }

        $this->commit();
        return $this->response($user, 200);

    }

    public function show(UserRequest $request, int $id) {
        $user = User::findOrFail($id);
        return $this->response($user, 200);

    }

    public function update(UserRequest $request, int $id) {
        $user = User::findOrFail($id);
        $data = $request->all();

        $this->beginTransaction();
        try {
            $user->update($data);
            if (!empty($data['password']) && !empty($data['confirm_password'])) {
                if ($data['password'] == $data['confirm_password']) {
                    $user->setPassword($data['password']);
                    $user->save();
                }
                else {
                    throw new \Exception(["message" => "Password and confirm password must match."]);
                }
            }
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();

        $user = $user->fresh();
        return $this->response($user, 200);

    }

    public function destroy(UserRequest $request, int $id) {
        $user = User::findOrFail($id);

        $this->beginTransaction();
        try{
            $user->delete();
        }
        catch (\Exception $ex){
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response('', 204);

    }
}
