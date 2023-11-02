@extends('layouts.master')

@section('title') Tech List @endsection

@section('content')

    <h2>Tech List</h2>
    <div class="well">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! displayNotification() !!}

        <fieldset>

            <legend>New tech</legend>

            <form method="post" action="{{ URL::route('techs') . '/create' }}">

                {{ csrf_field() }}

                <div class="row">
                    <div class="form-group">

                        <div class="col-xs-3">
                            <input class="form-control" name="name" id="name"
                                   placeholder="Tech's Name">
                        </div>

                        <div class="col-xs-3">
                            <input class="form-control" name="email" id="email"
                                   placeholder="Email">
                        </div>

                        <div class="col-xs-2">
                            <select class="form-control" name="shop">
                                <option value=""></option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->name }}">
                                        {{ $shop->name }}
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
            <legend>Existing techs</legend>
            @foreach($techs as $tech)
                <form method="post" action="{{ URL::route('techs') . '/' . $tech->id }}">

                    {{ csrf_field() }}

                    {{ method_field('PATCH') }}

                    <div class="row form-group">

                        <div class="col-xs-4">{{ $tech->name }} ({{$tech->email}})</div>

                        <div class="col-xs-4">
                            <select class="form-control" name="shop">
                                <option value=""></option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->name }}" {{ $tech->shop->name == $shop->name ? "selected" : "" }}>
                                        {{ $shop->name }}
                                    </option>
                                @endforeach
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