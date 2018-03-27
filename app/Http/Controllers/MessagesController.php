<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessage;
use App\Repositories\MessagesRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    private $repo;
    // model args
    public function __construct(MessagesRepository $messagesRepository)
    {
        $this->repo = $messagesRepository;
        //var_dump($messagesRepository);
        $this->middleware('auth');
    }

    /**
     * Afficher index
     * @return View
     */
    public function index() {
        return view("/messages/index",[
            'users' => $this->repo->getUsers(Auth::user()->id)
        ]);
    }

    /**
     * Afficher la conversation de l'utilisateur par identifiant
     * -> Marquer tous les messages lus.
     */
    public function show(User $user) {
        $messages = $this->repo->getMessages(Auth::user()->id, $user->id)->get(); // récupérer les messages
        // -> Marquer tous les messages lus.
        //chercher les messages non lue
        $unread = $this->repo->unReadCount(Auth::user()->id);
        if(isset($unread[$user->id])) {
               $this->repo->readAllFrom($user->id,Auth::user()->id); // lire tous les messages
        }
        return view("messages/show", [
            'users' => $this->repo->getUsers(Auth::user()->id),
            'user' => $user,
            'messages' => $messages
        ]);
    }

    /**
     * Post Request
     * Permet d'envoyer un message
     * @param User $user
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(User $user, SendMessage $req) {
        $this->repo->create(
            $req->get('content'),
            Auth::user()->id,
            $user->id
        );
        // redirection route nommé avec entrée utilisateur
        return redirect()->route('messages.show', ['id' => $user]);
    }
}
