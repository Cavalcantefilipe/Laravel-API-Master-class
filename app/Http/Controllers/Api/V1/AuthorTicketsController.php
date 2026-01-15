<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filters)->paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store($author_id, StoreTicketRequest $request)
    {

        try {

            $this->isAble('store', Ticket::class);

            $data = $request->mappedAttributes();
            $data['user_id'] = $author_id;

            return new TicketResource(Ticket::create($data));
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to create a ticket.', 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $author_id, string $ticket_id)
    {
        try {
            $ticket = Ticket::where('user_id', $author_id)->findOrFail($ticket_id);
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->ok('Ticket not found', [
                'error' => 'The provided ticket id does not exists.',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request,  $author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)->where('user_id', $author_id)->firstOrFail();

            $this->isAble('update', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $e) {
            return $this->ok('Ticket not found', [
                'error' => 'The provided ticket id does not exists.',
            ]);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to update this ticket.', 403);
        }
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)->where('user_id', $author_id)->firstOrFail();

            $this->isAble('replace', $ticket);

            return $ticket->update($request->mappedAttributes());
        } catch (ModelNotFoundException $e) {
            return $this->ok('Ticket not found', [
                'error' => 'The provided ticket id does not exists.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)->where('user_id', $author_id)->firstOrFail();

            $this->isAble('delete', $ticket);
            $ticket->delete();
            return $this->ok('Ticket deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket cannot be found', 404);
        }
    }
}
