<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTicketRequest;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserTicketController extends AuthController
{
    //
    public function index(UserTicketRequest $request) {
        return $this->response($this->currentUser()->tickets,200);
    }

    public function store(UserTicketRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try {
            $ticket = new Ticket($data);
            $ticket->created_by_id = $this->currentUser()->id;
            $ticket->updated_by_id = $this->currentUser()->id;
            $ticket->ticket_id = Uuid::uuid4();
            $ticket->save();
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response($ticket, 200);
    }

    public function show(UserTicketRequest $request, int $id) {
        $ticket = $this->currentUser()->tickets()->with('comments')->findOrFail($id);
        return $this->response($ticket,200);

    }

    public function update(UserTicketRequest $request, int $id) {
        $ticket = $this->currentUser()->tickets()->findOrFail($id);
        $data = $request->all();
        $this->beginTransaction();
        try{
            $ticket->update($data);
            $ticket->updated_by_id = $this->currentUser()->id;
            $ticket->save();
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();

        $ticket = $ticket->fresh('comments');
        return $this->response($ticket, 200);
    }

    public function delete(UserTicketRequest $request, int $id) {
        $ticket = $this->currentUser()->tickets()->findOrFail($id);
        $this->beginTransaction();
        try{
            $ticket->delete();
        }
        catch (\Exception $ex){
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response('',204);

    }
}
