<h1 class="page-title">{!! $user->username !!}</h1>

<div class="profile-basics row">
    <div class="col-md-8">
        <table class="table h">
            <tbody>
                <tr>
                    <th class="title">{!! trans('app.name') !!}</th>
                    <td>
                        @if ($user->country->icon)
                            {!! HTML::image($user->country->uploadPath().$user->country->icon, $user->country->title) !!}
                        @endif
                        {{ $user->first_name }} {{ $user->last_name }}
                    </td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::gender') !!}:</th>
                    <td>
                        @if ($user->gender == 0)
                            {!! HTML::fontIcon('genderless') !!} {{ trans('users::unknown') }}
                        @elseif ($user->gender == 1)
                            {!! HTML::fontIcon('venus') !!} {{ trans('users::female') }}
                        @elseif ($user->gender == 2)
                            {!! HTML::fontIcon('mars') !!} {{ trans('users::male') }}
                        @elseif ($user->gender == 3)
                            {!! HTML::fontIcon('genderless') !!} {{ trans('users::other') }}
                        @endif                        
                    </td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::language') !!}:</th>
                    <td>{{ $user->language->title }}</td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::birthdate') !!}:</th>
                    <td>{{ $user->birthdate }}</td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::occupation') !!}:</th>
                    <td>{{ $user->occupation }}</td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::website') !!}:</th>
                    <td>
                        @if(e($user->website))
                            {!! HTML::link(e($user->website)) !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="title">{!! trans('users::about') !!}:</th>
                    <td>{{ $user->about }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="details col-md-4">
        @if ($user->image)
            <img src="{!! $user->uploadPath().$user->image !!}" alt="{!! $user->username !!}">
        @else
            <img src="{!! asset('theme/user.png') !!}" alt="{!! $user->username !!}">
        @endif

        <div class="actions">
            @if (user())
                <a class="btn btn-default" href="{!! url('messages/create/'.$user->username) !!}" title="{!! trans('users::send_msg') !!}">{!! HTML::fontIcon('envelope') !!}</a>
                <a class="btn btn-default" href="{!! url('friends/add/'.$user->id) !!}" title="{!! trans('users::add_friend') !!}" <?php if (user()->id == $user->id or user()->isFriendWith($user->id)) echo 'disabled="disabled"' ?>>{!! HTML::fontIcon('user-plus') !!}</a>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="profile-socials">
            <table class="table h">
                <tbody>
                    <tr>
                        <th class="title">Facebook:</th>
                        <td><a href="{{ url('http://www.facebook.com/'.$user->facebook) }}" target="_blank">{{ $user->facebook }}</a></td>
                    </tr>
                    <tr>
                        <th class="title">Twitter:</th>
                        <td><a href="{{ url('http://www.twitter.com/'.$user->twitter) }}" target="_blank">{{ $user->twitter }}</a></td>
                    </tr>
                    <tr>
                        <th class="title">Skype:</th>
                        <td><a href="{{ url('skype:35?'.$user->facebook) }}" target="_blank">{{ $user->skype }}</a></td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::steam_id') !!}:</th>
                        <td><a href="http://steamcommunity.com/id/{{ $user->steam_id }}">{{ $user->steam_id }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="profile-favs">
            <table class="table h">
                <tbody>
                    <tr>
                        <th class="title">{!! trans('users::game') !!}:</th>
                        <td>{{ $user->game }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::food') !!}:</th>
                        <td>{{ $user->food }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::drink') !!}:</th>
                        <td>{{ $user->drink }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::music') !!}:</th>
                        <td>{{ $user->music }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::film') !!}:</th>
                        <td>{{ $user->film }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="profile-pc">
            <table class="table h">
                <tbody>
                    <tr>
                        <th class="title">{!! trans('users::cpu') !!}:</th>
                        <td>{{ $user->cpu }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::graphics') !!}:</th>
                        <td>{{ $user->graphics }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::ram') !!}:</th>
                        <td>{{ $user->ram }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::motherboard') !!}:</th>
                        <td>{{ $user->motherboard }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::drives') !!}:</th>
                        <td>{{ $user->drives }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::display') !!}:</th>
                        <td>{{ $user->display }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::mouse') !!}:</th>
                        <td>{{ $user->mouse }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::keyboard') !!}:</th>
                        <td>{{ $user->keyboard }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::headset') !!}:</th>
                        <td>{{ $user->headset }}</td>
                    </tr>
                    <tr>
                        <th class="title">{!! trans('users::mousepad') !!}:</th>
                        <td>{{ $user->mousepad }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>