<?php

namespace App\Repositories;

use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class MessagesRepository
{
    private $user;
    private $message;

    // model args
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Récupérer toutes les utilisateurs de conversation.
     *
     * @return mixed
     */
    public function getUsers(int $id)
    {
        $users = $this->user->newQuery()
            ->select('id', 'name', 'email', 'avatar')
            ->where('id', '<>', $id)
            ->get();
        $unread = $this->unReadCount($id);
        foreach ($users as $usr) {
            if (isset($unread[$usr->id])) {
                $usr->unread = $unread[$usr->id];
            } else {
                $usr->unread = 0;
            }
        }

        return $users;
    }

    /**
     * Créer un message.
     *
     * @param $content
     * @param $from_id
     * @param $to_id
     *
     * @return bool
     */
    public function create(string $content, int $from_id, int $to_id)
    {
        return $this->message->newQuery()->create([
            'content'    => $content,
            'from_id'    => $from_id,
            'to_id'      => $to_id,
            'created_at' => Carbon::now(), // date actuelle
        ]);
    }

    /**
     * Envoyer une requete pour la traiter plus tard
     * Récupérer les messages pour chaque conversation.
     *
     * @param int $from
     * @param int $to
     *
     * @return $this
     */
    public function getMessages(int $from, int $to) : Builder
    {
        return $this->message->newQuery()
            ->whereRaw("((from_id = $from AND to_id = $to) OR (from_id = $to AND to_id = $from))")
            ->orderBy('created_at', 'DESC')
            ->with('user'); // utilisateur en relation
    }

    /**
     * Récupérer le nombre des messages non lues pour chaque conversation
     * [
     *  'userid' => nombre message non lues
     * ].
     */
    public function unReadCount(int $userId)
    {
        /*
         * SELECT from_id, COUNT(id) as count FROM messages WHERE to_id='userID' AND read_at is null group by from_id
         */
        return $this->message->newQuery()
            ->where('to_id', $userId)
            ->groupBy('from_id')
            ->selectRaw('from_id, COUNT(id) as count')
            ->whereRaw('read_at IS NULL')
            ->get()
            ->pluck('count', 'from_id');   //tableau associatif
    }

    public function readAllFrom(int $from, int $to)
    {
        return $this->message->newQuery()
                ->where('from_id', $from)
                ->where('to_id', $to)
                ->update(['read_at' => Carbon::now()]);
    }
}
