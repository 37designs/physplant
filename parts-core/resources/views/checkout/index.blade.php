@extends('layouts.master')

@section('title') Checkout @endsection

@section('content')
    <form class="well form-horizontal" action="#" method="post" id="contact_form">

        {{ csrf_field() }}
        {!! displayNotification() !!}

        <fieldset>
            <legend style="text-align: left; font-size: 30px;">Checkout
                <button type="button" class="btn btn-primary btn-md" style="float:right;" id="myBtn">Tech First Time
                    Setup
                </button>
            </legend>
            @include('layouts.errors')
            <div class="form-group">
                <h2 id="direction" class="text-center"></h2>
            </div>

            <!-- Parts -->
            <div id="table-show">
                <hr>
                <h3 class="text-center">Parts in package</h3>
                <div id="parts-wrapper">
                    <table id="part-table" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Part #</th>
                            <th>Quantity</th>
                            <th>Part Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-lock"></span> Tech First Time Setup</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form" action="{{ URL::route('checkoutauth') }}" method="post">
                        {{ csrf_field() }}
                        <div id="modalMsgArea"></div>
                        <div class="form-group">
                            <label for="username"><span class="glyphicon glyphicon-user"></span> Emich NetID</label>
                            <input type="text" class="form-control" id="eid" name="eid" placeholder="Enter emich netid">
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter password">
                        </div>
                        <button type="submit" class="btn btn-success btn-block"><span
                                    class="glyphicon glyphicon-off"></span> Submit
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span
                                class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('js/jquery.scannerdetection.js') }}" type="text/javascript" charset="UTF-8"></script>

    <script type="text/javascript">
        titleBarMsg("Please scan your package.");

        var globaleid, partkey, partnum;

        $(document).scannerDetection({

            //https://github.com/kabachello/jQuery-Scanner-Detection

            timeBeforeScanTest: 200, // wait for the next character for upto 200ms
            avgTimeByChar: 40, // it' s not a barcode if a character takes longer than 100ms
            preventDefault: false,
            minLength: 3,
            endChar: [13],

            onComplete: function (msg) {
                determineScanType(msg);
            }
        });

        function determineScanType(scanData) {
            var staffCardIdPattern = /(?!;)\d*?(?=\?)/;
            var match = "" + staffCardIdPattern.exec(scanData); // Convert to string

            if (match && match.length === 16) { // Match staff card id pattern and is correct length.
                titleBarMsg("Processing ID card...");
                submitIDScan(match);
                return null;
            }

            if (!/[a-z]/.test(scanData.toLowerCase()) && scanData.includes('-') && scanData.split("-").length === 2 &&
                scanData.length >= 3) {
                titleBarMsg("Processing Barcode...");
                updateBarcodeScan(scanData);
                checkIfShouldPost();
                titleBarMsg("Please scan your ID.");
                return null;
            }
        }

        function submitIDScan(rawscan) {
            var eid = rawscan.substring(8, 15);
            if (eid == null || eid.length !== 7) {
                titleBarMsg("Bad ID scan. Please make sure it is a EMU Worker ID");
                return false;
            }


            $.ajax({
                url: '{{ URL::route('checkout') }}',
                type: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {eid: eid},
                dataType: 'json',
                success: function (response) {
                    if (response.length === 0) { // No user registered with swiped EID
                        modalMessage("We was unable to find your Employee card in our system. Please fill out this form and retry.");
                        $("#myModal").modal();
                        return;
                    }

                    globaleid = eid;
                    checkIfShouldPost();
                    titleBarMsg("Please scan your package.");
                }
            })
            ;
        }

        function updateBarcodeScan(rawscan) {

            var scan = rawscan.split('-');

            if (scan == null || scan[0] == null || scan[1] == null) {
                titleBarMsg("Bad barcode scan... Please try again.");
                return false;
            }


            $.ajax({
                url: '{{ URL::route('checkout') }}',
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {partnum: scan[0], partkey: scan[1]},
                dataType: 'json',
                success: function (response) {
                    $('#table-show').show();
                    $("#part-table > tbody > tr").remove(); // Clear table
                    response.forEach(updatePartTable);
                    partnum = scan[0];
                    partkey = scan[1];
                }
            });
        }

        function checkIfShouldPost() {
            console.log(globaleid + " : " + partnum + " : " + partkey);

            if (globaleid != null && partnum != null && partkey != null)
                post('{{ URL::route("checkout") }}', {
                    eid: globaleid,
                    partnum: partnum,
                    partkey: partkey,
                    _token: '{{ csrf_token() }}'
                });
        }

        function modalMessage(msg) {
            $('#modalMsgArea').html('<div class="alert alert-danger"><p>' + msg + '</p></div>');
        }

        function updatePartTable(item, index) {
            $('#part-table > tbody:last-child').append('<tr><th>' + item['id'] + '</th><th>' + item['final_quantity'] + '</th><th>' + item['part_number'] + '</th></tr>');
        }

        function titleBarMsg(msg) {
            $('#direction').text(msg);
        }

        function post(path, params, method) {
            method = method || "post"; // Set method to post by default if not specified.

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for (var key in params) {
                if (params.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);

                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        var waitingDialog = waitingDialog || (function ($) {
            'use strict';

            // Creating modal dialog's DOM
            var $dialog = $(
                '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
                '<div class="modal-dialog modal-m">' +
                '<div class="modal-content">' +
                '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
                '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
                '</div>' +
                '</div></div></div>');

            return {
                /**
                 * Opens our dialog
                 * @param message Custom message
                 * @param options Custom options:
                 *                  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
                 *                  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
                 */
                show: function (message, options) {
                    // Assigning defaults
                    if (typeof options === 'undefined') {
                        options = {};
                    }
                    if (typeof message === 'undefined') {
                        message = 'Loading';
                    }
                    var settings = $.extend({
                        dialogSize: 'm',
                        progressType: '',
                        onHide: null // This callback runs after the dialog was hidden
                    }, options);

                    // Configuring dialog
                    $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                    $dialog.find('.progress-bar').attr('class', 'progress-bar');
                    if (settings.progressType) {
                        $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                    }
                    $dialog.find('h3').text(message);
                    // Adding callbacks
                    if (typeof settings.onHide === 'function') {
                        $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                            settings.onHide.call($dialog);
                        });
                    }
                    // Opening dialog
                    $dialog.modal();
                },
                /**
                 * Closes dialog
                 */
                hide: function () {
                    $dialog.modal('hide');
                }
            };

        })(jQuery);

        $(document).ready(function () {
            titleBarMsg("Please scan your package.");
            $('#table-show').hide();

            $("#myBtn").click(function () {
                $("#myModal").modal();
            });
        });
    </script>

    <style>
        .table {
            overflow: hidden;
        }

        .modal-header, h4, .close {
            background-color: #5cb85c;
            color: white !important;
            text-align: center;
            font-size: 30px;
        }

        h3 {
            text-align: center;
            font-size: 23px;
            padding: 5px;
        }

        .modal-footer {
            background-color: #f9f9f9;
        }
    </style>
@endsection