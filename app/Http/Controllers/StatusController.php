<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use Illuminate\Http\Request;
use App\Status;

class StatusController extends Controller
{
    //

    public function index(StatusRequest $request) {
        return $this->response(Status::all(), 200);

    }

    public function store(StatusRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try{
            $status = Status::create($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }

        $this->commit();
        return $this->response($status, 200);

    }

    public function show(StatusRequest $request, int $id) {
        $status = Status::findOrFail($id);
        return $this->response($status, 200);

    }

    public function update(StatusRequest $request, int $id) {
        $status = Status::findOrFail($id);
        $data = $request->all();

        $this->beginTransaction();
        try {
            $status->update($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();

        $status = $status->fresh();
        return $this->response($status, 200);

    }

    public function destroy(StatusRequest $request, int $id) {
        $status = Status::findOrFail($id);

        $this->beginTransaction();
        try{
            if($status->tickets->count() > 0) {
                throw new \Exception(['message' => 'Cannot delete a Status in use.']);
            }

            $status->delete();
        }
        catch (\Exception $ex){
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response('', 204);

    }
}
