@extends('layouts.app')
@section('header')
<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Mon profile
            </h1>
        </div>
    </div>
</section>
@endsection
@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-2">
                <img src="/uploads/avatars/{{ $user->avatar }}" class="floatingImg" style="width:150px;"/>
            </div>
            <div class="column">
                <div class="content" style="margin-top: 10px">

                    @if($errors->any())
                        <div class="notification is-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    @if(session()->has('success'))
                            <div class="notification is-success">
                                {{ session('success') }}
                            </div>
                    @endif

                    <p>
                    <h2><strong>{{ $user->name }}</strong></h2>
                    <h4>{{$user->email}}</h4>
                    </p>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="level"><div class="level-left">
                                {!! csrf_field() !!}
                                <input type="file" name="avatar" id="file" class="inputfile" />
                                <label for="file">

                                    <i class="fa fa-upload"></i>
                                    Choisir une photo de profile</label>

                            </div><div class="level-right">

                                <input type="submit" class="button is-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection