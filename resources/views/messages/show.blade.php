@extends('layouts.app')
@section('header')
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Messagerie
                </h1>
            </div>
        </div>
    </section>
@endsection
@section('content')
<div class="container">
    <div class="columns is-marginless">
    @include('messages.users', ['users' => $users])
    <div class="column">
        <div id="chatview" class="p1">
            <div id="profile">
                <img src="/uploads/avatars/{{ $user->avatar }}" class="floatingImg">
                <p>{{ $user->name }}</p>
                <span>{{ $user->email }}</span>
            </div>
            <div id="chat-messages">
                <label>Thursday 02</label>
                @foreach($messages as $message)
                <div class="message @if($message->from_id == Auth::user()->id) {{ "right" }} @endif">
                    <img src="/uploads/avatars/{{ $message->user->avatar }}" />
                    <div class="bubble">
                        {{ $message->content }}
                        <div class="corner"></div>
                        <span>3 min</span>
                    </div>
                </div>
                @endforeach

            </div>

            <div id="sendmessage">
                <form method="POST" action="">
                    {!! csrf_field() !!}
                    <input type="text" name="content" placeholder="Entrez un message..." {!!  $errors->has('content') ? 'style="border: 1px solid #de7b7b;width: 88%;"' : '' !!} style="width: 88%;border-right: 1px solid #ececec;"/>
                    <input type="submit" class="button is-primary" value="Envoyer">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection