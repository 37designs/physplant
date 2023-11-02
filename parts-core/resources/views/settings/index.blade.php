@extends('layouts.master')

@section('title') Request Parts @endsection

@section('content')
    <div class="container">

        <form class="well form-horizontal" action="{{ URL::route('settings') }}" method="post" id="contact_form">

            {{ csrf_field() }}

            {!! displayNotification() !!}

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <fieldset>
                <legend style="text-align: center; font-size: 25px;">Settings</legend>

                <!-- Select Shop -->
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 control-label"></label>
                    <div class="col-md-4 col-sm-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon">Select Shop</span>
                            <select name="shop" class="form-control" title="Shop" required>
                                @if(!isset($currentShop))
                                    <option value="-1" selected>None</option>
                                @endif

                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}"
                                            @if(isset($currentShop) && $shop->id == $currentShop)
                                            selected
                                            @endif>
                                        {{ $shop->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <button name="submit" class="btn btn-success btn-lg" id="submit-btn">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection