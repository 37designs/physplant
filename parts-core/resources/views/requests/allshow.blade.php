@extends('layouts.master')

@section('title') Request #{{ $partNum }}@endsection

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default container">

                @if(isset($noRequest))
                    <h2>Not a part request</h2>
                    <hr>
                    <p class="text-center">Could not find a part request by the number specified.</p>
                @else
                    <fieldset>
                        <h2>Part request #{{ $partNum }}</h2>
                        <hr>
                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Part Request Details</div>
                                        <div class="panel-body">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td style="border:none;" class="text-right col-md-6"><label>Tradesperson:</label>
                                                    </td>
                                                    <td style="border:none;">{{ $partrequest->technician->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><label>Request Date:</label></td>
                                                    <td>{{ $partrequest->created_at->setTimezone('America/Detroit')->format('m/d/Y g:ia') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><label>Work Order #:</label></td>
                                                    <td>{{ $partrequest->work_order }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><label>Request #:</label></td>
                                                    <td>{{ $partrequest->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right"><label>Status:</label></td>
                                                    <td>{{ $partrequest->getRequestStatus() }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    @include('layouts.comments', array('requestID'=>$partrequest->id, 'tech' => $partrequest->technician->name))
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">All Parts</div>
                                    <div class="panel-body">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <!--
                                        <form method="POST"
                                              action="{{ URL::route('requests') . "/" . $partrequest->id }}">
                                        !-->
                                        <form method="POST"
                                              action="{{ URL::route('requests') . '/' . $partrequest->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}

                                            <table id="table" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-1">Id</th>
                                                    <th class="col-md-1">Quantity</th>
                                                    <th class="col-md-1">Part #</th>
                                                    <th class="col-md-1">Vendor</th>
                                                    <th class="col-md-3">Description</th>
                                                    <th class="col-md-1">Expedite</th>
                                                    <th class="col-md-1">Foreperson Decision</th>
                                                    <th class="col-md-1">Shipping Status</th>
                                                    <th class="col-md-1">Signature</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($partrequest->parts as $part)
                                                    <tr>
                                                        <td>{{$part->id}}</td>
                                                        <td>{{$part->request_quantity}} / {{$part->final_quantity}}</td>
                                                        <td>{{ $part->part_number }}</td>
                                                        <td>{{ $part->vendor->name}}</td>
                                                        <td>{{ $part->description }}</td>
                                                        <td>
                                                            @if($part->asked_for_expedite)
                                                                Yes /
                                                                @if($part->expedite)
                                                                    Yes
                                                                @else
                                                                    No
                                                                @endif
                                                            @else
                                                                No /
                                                                @if($part->expedite)
                                                                    Yes
                                                                @else
                                                                    No
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $part->ApprovalStatus->name }}
                                                            @isset($part->observer)
                                                                by,
                                                                <br>
                                                                {{ $part->observer->name }}
                                                            @endisset
                                                        </td>
                                                        <td>
                                                            {{ $part->receivedStatus->name }}
                                                        </td>
                                                        <td>
                                                            @if($part->signature == null)
                                                                none
                                                            @else
                                                                {{$part->signature->name}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button name="submit"
                                                            class="btn btn-primary btn-lg col-md-3 col-lg-offset-9"
                                                            id="submit-btn">
                                                        Submit <span class="glyphicon glyphicon-inbox"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable();
        });

        function checkAll(ele, name) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && checkboxes[i].id == name) {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    console.log(i)
                    if (checkboxes[i].type == 'checkbox' && checkboxes[i].id == name) {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

        function radioCheckAll(ele, name) {
            var radioboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < radioboxes.length; i++) {
                    if (radioboxes[i].type == 'radio' && radioboxes[i].id == name) {
                        radioboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < radioboxes.length; i++) {
                    console.log(i)
                    if (radioboxes[i].type == 'radio' && radioboxes[i].id == name) {
                        radioboxes[i].checked = false;
                    }
                }
            }
        }
    </script>
@endsection

@section('footer')
    <datalist id="vendors">
        @foreach (App\Vendor::all() as $vendor)
            <option value="{{ $vendor->name }}">
        @endforeach
    </datalist>
@endsection