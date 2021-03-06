<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriorityRequest;
use App\Priority;
use Illuminate\Http\Request;

class PriorityController extends AuthController
{
    /***
     * Return list of Priority Objects
     *
     * @param PriorityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(PriorityRequest $request) {
        return $this->response(Priority::all(), 200);

    }

    /***
     * Creates a new Priority Object.
     *
     * @param PriorityRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
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

    /***
     * Returns Priority Object with corresponding $id.
     *
     * @param PriorityRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(PriorityRequest $request, int $id) {
        $priority = Priority::findOrFail($id);
        return $this->response($priority, 200);

    }

    /***
     * Updates Priority Object with corresponding $id.
     *
     * @param PriorityRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
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

    /***
     * Deletes Priority Object with corresponding $id.
     *
     * @param PriorityRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
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
