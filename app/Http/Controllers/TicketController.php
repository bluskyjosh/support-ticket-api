<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Ticket;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TicketController extends AuthController
{
    /***
     * Returns list of all Ticket Objects
     *
     * @param TicketRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(TicketRequest $request) {
        return $this->response(Ticket::all(), 200);
    }

    /***
     * Creates a new Ticket Object.
     *
     * @param TicketRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(TicketRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try{
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
        return $this->response($ticket,200);
    }

    /***
     * Returns Ticket Object with $id.
     *
     * @param TicketRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(TicketRequest $request, int $id) {
        $ticket = Ticket::with(['comments'])->findOrFail($id);
        return $this->response($ticket,200);
    }

    /***
     * Updates Ticket Object with $id.
     *
     * @param TicketRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, int $id) {
        $ticket = Ticket::findOrFail($id);
        $data = $request->all();
        $this->beginTransaction();
        try {
            $ticket->update($data);
            $ticket->updated_by_id = $this->currentUser()->id;
            $ticket->save();
        }
        catch(\Exception $ex) {
            $this->rollback();
        }
        $this->commit();
        $ticket =$ticket->fresh(['comments']);
        return $this->response($ticket, 200);

    }

    /***
     * Deletes Ticket Object with $id.
     *
     * @param TicketRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TicketRequest $request, int $id) {
        $ticket = Ticket::findOrFail($id);
        $this->beginTransaction();
        try {
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
