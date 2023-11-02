@extends('layouts.master')

@section('title') User List @endsection

@section('content')

    <h2>User List</h2>
    <div class="well">

        {!! displayNotification() !!}

        <fieldset>

            <legend>New user</legend>

            <form method="post" action="{{ URL::route('users') . '/create' }}">

                {{ csrf_field() }}

                <div class="row">
                    <div class="form-group">

                        <div class="col-xs-4">
                            <input class="form-control" name="username" id="username"
                                   placeholder="EMU Username / NetID">
                        </div>

                        <div class="col-xs-2">
                            <select class="form-control" name="role">
                                <option value=""></option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-2"></div>
                        <div class="col-xs-2">
                            <button class="btn btn-primary">Create</button>
                        </div>

                    </div>
                </div>
            </form>

        </fieldset>

        {{-- vertical spacing --}}
        <div class="row" style="height:50px;"></div>

        <fieldset>
            <legend>Existing users</legend>
            @foreach($users as $user)
                <form method="post" action="{{ URL::route('users') . '/' . $user->id }}">

                    {{ csrf_field() }}

                    {{ method_field('PATCH') }}

                    <div class="row form-group">

                        <div class="col-xs-3">{{ $user->name . " <" . $user->email() . ">" }}</div>

                        <div class="col-xs-2">
                            <select class="form-control" name="role">
                                <option value=""></option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? "selected" : "" }}>
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-2">
                            <select class="form-control" name="technician">
                                <option value="testing"> </option>

                            </select>
                        </div>

                        <div class="col-xs-2"></div>
                        <div class="col-xs-2">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </form>
            @endforeach
        </fieldset>

    </div>
@endsection