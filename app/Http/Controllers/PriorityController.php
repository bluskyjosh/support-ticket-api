<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriorityRequest;
use App\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    //

    public function index(PriorityRequest $request) {
        return $this->response(Priority::all(), 200);

    }

    public function store(PriorityRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try{
            $priority = Priority::create($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }

        $this->commit();
        return $this->response($priority, 200);

    }

    public function show(PriorityRequest $request, int $id) {
        $priority = Priority::findOrFail($id);
        return $this->response($priority, 200);

    }

    public function update(PriorityRequest $request, int $id) {
        $priority = Priority::findOrFail($id);
        $data = $request->all();

        $this->beginTransaction();
        try {
            $priority->update($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();

        $priority = $priority->fresh();
        return $this->response($priority, 200);

    }

    public function destroy(PriorityRequest $request, int $id) {
        $priority = Priority::findOrFail($id);

        $this->beginTransaction();
        try{
            if($priority->tickets->count() > 0) {
                throw new \Exception(['message' => 'Cannot delete a priority in use.']);
            }

            $priority->delete();
        }
        catch (\Exception $ex){
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response('', 204);

    }
}
