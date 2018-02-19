<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTicketRequest;
use App\Notifications\TicketNotification;
use App\Ticket;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserTicketController extends AuthController
{
    /***
     * Returns list of all Ticket Objects belonging to current user.
     *
     * @param UserTicketRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(UserTicketRequest $request) {
        return $this->response($this->currentUser()->submitted_ickets()->with(['category','priority','status','comments'])->get(),200);
    }

    /***
     * Creates a new Ticket Object.
     *
     * @param UserTicketRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(UserTicketRequest $request) {
        $data = $request->all();
        $this->beginTransaction();
        try {
            $ticket = new Ticket($data);
            $ticket->created_by_id = $this->currentUser()->id;
            $ticket->updated_by_id = $this->currentUser()->id;
            $ticket->ticket_id = Uuid::uuid4();
            $ticket->save();

            Notification::send($this->currentUser(), new TicketNotification($ticket));
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response($ticket, 200);
    }


    /***
     * Returns Ticket Object with $id.
     *
     * @param UserTicketRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserTicketRequest $request, int $id) {
        $ticket = $this->currentUser()->tickets()->with(['category','priority','status','comments'])->findOrFail($id);
        return $this->response($ticket,200);

    }

    /***
     * Updates Ticket Object with $id.
     *
     * @param UserTicketRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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

        $ticket = $ticket->fresh(['category','priority','status','comments']);
        return $this->response($ticket, 200);
    }

    /***
     * Deletes Ticket Object with $id.
     *
     * @param UserTicketRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
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
