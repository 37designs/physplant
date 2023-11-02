@extends('layouts.master')

@section('title') All Requests @endsection

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default container">
                <fieldset>
                    <h2>All Requests For {{ $shopname }}</h2>
                    <hr>
                    @if(isset($unapprovedShopRequests) && count($unapprovedShopRequests) > 0)
                        <form class="well form-horizontal" action="{{ URL::route('requests') }}" method="post"
                              id="contact_form">

                            {{ csrf_field() }}

                            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="col-md-1">Request Number</th>
                                    <th class="col-md-2">Work Order</th>
                                    <th class="col-md-1">Tradesperson</th>
                                    <th class="col-md-2">Date</th>
                                    <th class="col-md-4">Description</th>
                                    <th class="col-md-1">Approve
                                        <input type="checkbox" class="check" id="select-all" onClick="checkAll(this)">
                                    </th>
                                    <th class="col-md-1">Expedite</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="col-md-1">Request Number</th>
                                    <th class="col-md-2">Work Order</th>
                                    <th class="col-md-1">Tradesperson</th>
                                    <th class="col-md-2">Date</th>
                                    <th class="col-md-4">Description</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($unapprovedShopRequests as $unShopReq)
                                    <tr>
                                        <td class="clickable">
                                            <a href="{{  url('/requests/'.$unShopReq->id) }}">{{ $unShopReq->id }}</a>
                                        </td>
                                        <td>{{ $unShopReq->work_order }}</td>
                                        <td>{{ $unShopReq->technician->name }}</td>
                                        <td>{{ $unShopReq->created_at->setTimezone('America/Detroit')->format('m/d/Y g:ia') }}</td>
                                        <td>
                                            @php
                                                $desc = App\Comment::where('request_id', '=', $unShopReq->id)->first()
                                            @endphp
                                            {{ isset($desc) ? $desc->comment : "" }}
                                        </td>
                                        <input type="hidden" name="req[{{ $unShopReq->id }}][requestid]"
                                               value="{{ $unShopReq->id }}">
                                        <td><span><input id='approve' class="check" type="checkbox"
                                                         name="req[{{ $unShopReq->id }}][approve]" value="1"></span>
                                        </td>
                                        <td><span><input class="check" type="checkbox"
                                                         name="req[{{ $unShopReq->id }}][expedite]" value="1"></span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button name="submit" class="btn btn-primary btn-lg col-md-3 col-lg-offset-9"
                                            id="submit-btn">
                                        Process <span class="glyphicon glyphicon-inbox"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <h4>No currently open part requests.</h4>
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table tfoot th').each(function () {
                $(this).html('<input id="searchable" class="table table-fit" placeholder="Search" />');
            });

            var table = $('#table').DataTable();

            table.columns().every(function () {
                var that = this;

                $('#searchable', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });

        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && checkboxes[i].id == 'approve') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    console.log(i)
                    if (checkboxes[i].type == 'checkbox' && checkboxes[i].id == 'approve') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }

    </script>

    <style>
        .clickable {
            cursor: pointer;
            cursor: hand;
        }
    </style>
    <script>
        $().ready(function () {
            $(".clickable").click(function () {
                window.location.href = $(this).find("a").attr("href");
            });
        });
    </script>
@endsection