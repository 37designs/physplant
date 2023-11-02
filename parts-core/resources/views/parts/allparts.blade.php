<!-- WIP DOES NOTHING YET -->
@extends('layouts.master')

@section('title') All Requests @endsection

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default container">
                <div class="panel-body">
                    <h2>All Requests</h2>
                    <hr>

                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                aaSorting: [[4, 'desc']],
                pageLength: 25,
                ajax: '{!! route('allrequestsdata') !!}',
                columns: [
                    {data: 'id', name: 'id', className: 'clickable'},
                    {data: 'work_order', name: 'requests.work_order'},
                    {data: 'technician.name', name: 'technician.name'},
                    {data: 'technician.shop.name', name: 'technician.shop.name'},
                    {data: 'created_at', name: 'requests.created_at'},
                    {data: 'parts[, ].vendor.name', searchable: false, orderable: false},
                    {data: 'status', searchable: false, orderable: false}
                ],
                createdRow:
                    function (row, data, index) {
                        $('td', row).eq(6).addClass('alert-' + data['status_color']);
                    }
            })
            ;
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

        tr td a {
            width: 100%;
        }

        .clickable:hover {
            background: #c7ddef;
        }
    </style>
@endsection