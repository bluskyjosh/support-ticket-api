<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Ticket;
use Illuminate\Http\Request;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;

class TicketCommentController extends AuthController
{
    /***
     * Returns list of Comment Objects belonging to a Ticket
     * Object with corresponding $ticket_id.
     *
     * @param CommentRequest $request
     * @param int $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function index(CommentRequest $request, int $ticket_id) {
        $ticket = $this->getTicket($ticket_id);
        return $this->response($ticket->comments, 200);

    }

    /***
     * Creates new Comment Object belonging to Ticket Object
     * with corresponding $ticket_id.
     *
     * @param CommentRequest $request
     * @param int $ticket_id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(CommentRequest $request, int $ticket_id) {
        $ticket = $this->getTicket($ticket_id);
        $data = $request->all();
        $this->beginTransaction();
        try {
            $data['created_by_id'] = $this->currentUser()->id;
            $comment = $ticket->comments()->create($data);

            Notification::send($ticket->created_by, new CommentNotification($comment, $this->currentUser()));
        }
        catch (\Exception $ex){
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        return $this->response($comment, 200);
    }

    /***
     * Returns a Single Comment Object with $comment_id belonging
     * to Ticket Object with $ticket_id.
     *
     * @param CommentRequest $request
     * @param int $ticket_id
     * @param int $comment_id
     * @return \Illuminate\Http\Response
     */
    public function show(CommentRequest $request, int $ticket_id, int $comment_id) {
        $ticket = $this->getTicket($ticket_id);
        return $this->response($ticket->comments()->findOrFail($comment_id), 200);
    }

    /***
     * Updates Comment Object with $comment_id belonging to
     * Ticket Object with $ticket_id.
     *
     * @param CommentRequest $request
     * @param int $ticket_id
     * @param int $comment_id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(CommentRequest $request, int $ticket_id, int $comment_id) {
        $ticket = $this->getTicket($ticket_id);
        $comment = $ticket->comments()->findOrFail($comment_id);
        $data = $request->all();
        $this->beginTransaction();
        try{
            $comment->update($data);
        }
        catch (\Exception $ex) {
            $this->rollback();
            throw $ex;
        }
        $this->commit();
        $comment = $comment->fresh();
        return $this->response($comment, 200);

    }

    /***
     * Deletes Comment Object with $comment_id belonging to
     * Ticket Object with $ticket_id
     *
     * @param CommentRequest $request
     * @param int $ticket_id
     * @param int $comment_id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(CommentRequest $request, int $ticket_id, int $comment_id) {
        $ticket = $this->getTicket($ticket_id);
        $comment = $ticket->comments()->findOrFail($comment_id);
        $this->beginTransaction();
        try{
            $comment->delete();
        }
        catch (\Exception $ex){
            $this->rollback();
            throw $ex;
        }
        $this->commit();

        return $this->response('', 204);
    }

    /***
     * Returns Ticket Object for current user.
     *
     * @param int $ticket_id
     * @return mixed
     */
    protected function getTicket(int $ticket_id) {
        // If the user is not an admin, check to see if they are the poster of the
        // original ticket. If not, do not allow them to comment.
        if(!$this->currentUser()->is_admin){
            $ticket = $this->currentUser()->tickets()->findOrFail($ticket_id);
        }
        else {
            $ticket = Ticket::findOrFail($ticket_id);
        }
        return $ticket;
    }
}
