@extends('layouts.master')

@section('title') Home @endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <p>Welcome to the Physplant Parts System!</p>
                        <hr>

                        @role('new')
                        <p>Your name was successfully added to the users list. Please ask the Physical Plant IT office
                            to give you access.</p>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
