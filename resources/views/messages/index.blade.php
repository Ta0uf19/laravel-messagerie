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
    <div class="container" id="messagerie" data-base="{{ route('messages',[], false) }}">
        <Messagerie :user="{{ Auth::user()->id }}"></Messagerie>
        <!--List des utilisateurs -->
        {{--<div class="columns is-marginless">--}}
            {{--@include('messages.users', ['users' => $users])--}}
        {{--</div>--}}
    </div>
@endsection