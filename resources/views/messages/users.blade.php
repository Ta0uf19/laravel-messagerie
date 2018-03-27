

        <div class="column is-3">
            <div id="chatbox">
                <div id="friendslist">
                    <div id="topmenu">
                        <span class="friends"></span>
                    </div>

                    <div id="friends">
                        @foreach($users as $user)
                        <a href="/messages/{{ $user->id }}">
                            <div class="friend">
                            <img src="/uploads/avatars/{{ $user->avatar }}" />
                            <p>
                                <strong {!!  (isset($user->unread) && $user->unread != 0) ? 'class="badge" data-badge="'.$user->unread.'"' : '' !!} >
                                    {{ $user->name }}
                                </strong>
                                <span>{{ $user->email }}</span>
                            </p>
                            <div class="status inactive"></div>
                        </div>
                        </a>
                        @endforeach
                        <div class="friend">
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1_copy.jpg" />
                            <p>
                                <strong>Miro Badev</strong>
                                <span>mirobadev@gmail.com</span>
                            </p>
                            <div class="status available"></div>
                        </div>

                        <div class="friend">
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2_copy.jpg" />
                            <p>
                                <strong>Martin Joseph</strong>
                                <span>marjoseph@gmail.com</span>
                            </p>
                            <div class="status away"></div>
                        </div>
                        {{--<div id="search">--}}
                            {{--<input type="text" id="searchfield" value="Search contacts..." />--}}
                        {{--</div>--}}

                    </div>

                </div>

        </div>
        </div>




