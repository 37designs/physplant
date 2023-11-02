@extends('layouts.master')

@section('title') All Requests @endsection


@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default container">
                <fieldset>
                    <h2>All Materials Requests</h2>
                    <hr>
                    <table id="ajaxtable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="col-md-1">Request Number</th>
                            <th class="col-md-2">Work Order</th>
                            <th class="col-md-1">Tradesperson</th>
                            <th class="col-md-1">Trade</th>
                            <th class="col-md-2">Date</th>
                            <th class="col-md-4">Vendors</th>
                            <th class="col-md-1">Status</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="col-xs-12" style="height:50px;"></div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#ajaxtable').DataTable({
                processing: true,
                serverSide: true,
                aaSorting: [[4, 'desc']],
                pageLength: 50,
                ajax: '{!! route('materialsdata') !!}',
                columns: [
                    {data: 'id', name: 'id', className: 'clickable'},
                    {data: 'work_order', name: 'work_order'},
		   /* {data: 'status_color', name: 'status_color'},*/
                    {data: 'tech_name', name: 'tech_name'},
                    {data: 'tech_trade', name: 'tech_trade'},
                    {data: 'date', name: 'created_at'},
                    {data: 'vendors', name: 'vendors'},
                    {data: 'status', name: 'status'}
                   
                ],
                createdRow: function (row, data, index) {
                    $('td', row).eq(6).addClass('alert-' + data['status_color']);
                }
            });
        });
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

