@extends('layouts.master')

@section('title') Received Manager @endsection

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default container">
                <fieldset>
                    <h2>Received Manager</h2>
                    <hr>
                    @if(isset($inStockRequests) && count($inStockRequests) > 0)
                        <table id="table" class="table table-sm table-hover table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="col-sm-1">Request Number</th>
                                <th class="col-sm-2">Work Order</th>
                                <th class="col-sm-1">Tradesperson</th>
                                <th class="col-sm-2">Date Created</th>
                                <th class="col-sm-2">Trade</th>
                                <th class="col-sm-4">Description</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th class="col-sm-1">Request Number</th>
                                <th class="col-sm-2">Work Order</th>
                                <th class="col-sm-1">Tradesperson</th>
                                <th class="col-sm-2">Date Created</th>
                                <th class="col-sm-2">Trade</th>
                                <th class="col-sm-4">Description</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($inStockRequests as $ShopReq)
                                <tr>
                                    <td class="clickable">
                                        <a href="{{  url('/receivedmanager/'.$ShopReq->id) }}">{{ $ShopReq->id }}</a>
                                    </td>
                                    <td>{{ $ShopReq->work_order }}</td>
                                    <td>{{ $ShopReq->technician->name }}</td>
                                    <td>{{ $ShopReq->created_at->setTimezone('America/Detroit')->format('m/d/Y g:ia') }}</td>
                                    <td>{{ $ShopReq->scopeShop()->name }}</td>
                                    <td>
                                        @php
                                            $desc = App\Comment::where('request_id', '=', $ShopReq->id)->first()
                                        @endphp
                                        {{ isset($desc) ? $desc->comment : "" }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12" style="height:50px;"></div>
                    @else
                        <div class="text-center">
                            <h4>No currently open part requests that need to be managed.</h4>
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

            $('[data-toggle="popover"]').popover({
                placement: 'right',
                html: true,
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