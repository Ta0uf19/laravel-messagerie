<?php
namespace App\Http\Controllers\Api;
use App\Http\Requests\SendMessage;
use App\Repositories\MessagesRepository;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    private $repo;
    public function __construct(MessagesRepository $messagesRepository)
    {
        $this->repo = $messagesRepository;
    }

    public function index(Request $request) {
        return [
                'users'  => $this->repo->getUsers($request->user()->id)
            ];
    }

    /**
     * Afficher la conversation de l'utilisateur par identifiant
     * -> Marquer tous les messages lus.
     */
    public function show(Request $request,User $user) {
        $messages = $this->repo->getMessages($request->user()->id, $user->id); // récupérer les messages
        // -> Marquer tous les messages lus.
        //chercher les messages non lue
        $unread = $this->repo->unReadCount($request->user()->id);
        if(isset($unread[$user->id])) {
            $this->repo->readAllFrom($user->id,$request->user()->id); // lire tous les messages
        }

        if($request->get('before')) {
            $messages = $messages->where('created_at', '<', $request->get('before'));
        }
        return [
            'messages' => array_reverse($messages->limit(10)->get()->toArray()),
            'count' => $request->get('before') ? '' : $messages->count()
        ];
    }

    /**
     * Post Request
     * Permet d'envoyer un message
     * @param User $user
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(User $user, SendMessage $req) {
        $message = $this->repo->create(
            $req->get('content'),
            $req->user()->id,
            $user->id
        );
        $return = ['message' => $message];
        $return['message']['user'] = $req->user();
        //permet d'ajouter la relation user à la fin du tableau
        return $return;
    }
}