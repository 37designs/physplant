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
                        <h2 class="text-center">Received Manager</h2>
                        <h3 class="text-center">Part Request #{{ $partNum }}</h3>
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
                                        <form method="POST"
                                              action="{{ URL::route('receivedmanager') . "/" . $partrequest->id }}"
                                              onsubmit="return printLabel();">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}

                                            <table id="table" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-1">Quantity</th>
                                                    <th class="col-md-2">Part #</th>
                                                    <th class="col-md-2">Vendor</th>
                                                    <th class="col-md-3">Description</th>
                                                    <th class="col-md-1">Signed</th>
                                                    <th class="col-md-1">Key</th>
                                                    <th class="col-md-1">Print</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th class="col-md-1"></th>
                                                    <th class="col-md-2"></th>
                                                    <th class="col-md-2"></th>
                                                    <th class="col-md-3"></th>
                                                    <th class="col-md-1"></th>
                                                    <th class="col-md-1"></th>
                                                    <th class="col-md-1">
                                                        <button id="printButton" name="submit" class="btn btn-primary"
                                                                id="submit-btn">
                                                            Print
                                                        </button>
                                                    </th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($partrequest->parts as $part)
                                                    <tr>
                                                        <td>{{ $part->request_quantity }}</td>
                                                        <td>{{ $part->part_number }}</td>
                                                        <td>{{ $part->vendor->name }}</td>
                                                        <td>{{ $part->description }}</td>
                                                        <td>No</td>
                                                        <td id="dbkey">{{ $part->received_key }}</td>
                                                        <td>
                                                            <input id='print' class="check" type="checkbox"
                                                                   name="part[{{ $part->id }}][selected]"
                                                                   onclick="PrintListCheckboxChangeEvent({{ $part->id }})"
                                                                   value="1">

                                                        </td>
                                                        <input type="hidden" name="part[{{ $part->id }}][partid]"
                                                               value="{{ $part->id }}">
                                                        <input type="hidden" name="part[{{ $part->id }}][tradersperson]"
                                                               value="{{ $partrequest->technician->name }}">
                                                        <input type="hidden" name="part[{{ $part->id }}][reqnum]"
                                                               value="{{ $partrequest->id }}">
                                                        <input type="hidden" name="part[{{ $part->id }}][partnum]"
                                                               value="{{ $part->part_number }}">
                                                        <input type="hidden" id="partkey"
                                                               name="part[{{ $part->id }}][key]"
                                                               value="{{ $part->received_key }}">
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
    <script src="{{ URL::asset('js/dymoprint.js') }}" type="text/javascript" charset="UTF-8"></script>

    <script type="text/javascript" charset="UTF-8">

        var printList = [];

        $(document).ready(function () {
            $('#table').DataTable();

            var RANDOMKEY = randomNumbers();

            var keybox = document.getElementsByTagName('input');
            for (var i = 0; i < keybox.length; i++) {
                if (keybox[i].type == 'hidden' && keybox[i].id == "partkey" && keybox[i].value == "") {
                    keybox[i].value = RANDOMKEY;
                }
            }
        });

        function PrintListCheckboxChangeEvent(value) {
            if (printList.includes(value))
                printList.splice(printList.indexOf(value), 1);
            else
                printList[printList.length] = value;

            UpdatePrintButtonName();
        }

        function UpdatePrintButtonName() {
            var printbutton = document.getElementById('printButton');

            if (printList.length > 1)
                printbutton.innerText = "Print Batch";
            else
                printbutton.innerText = "Print";
        }

        function randomNumbers() {
            var randVal = 101 + (Math.random() * (999 - 101));
            return "" + Math.round(randVal);
        }

        function printLabel() {
            if (printList.length < 1) {
                alert("You need to select a part before you can print!");
                return false;
            }

            var partsToPrint = "";

            for (var i = 0; i < printList.length; i++) {
                var partnumval = document.getElementsByName('part[' + printList[i] + '][partnum]');
                partsToPrint += "- " + partnumval[0].value + "\n";
            }

            var shouldContinue = confirm("Are you sure you want to print the parts below in bulk?\n\n" + partsToPrint + "\n*Parts printed in bulk will be handled the same way.");

            if (!shouldContinue)
                return false;

            var tradesperson = document.getElementsByName('part[' + printList[0] + '][tradersperson]')[0].value;
            var reqnum = document.getElementsByName('part[' + printList[0] + '][reqnum]')[0].value;
            var key = document.getElementsByName('part[' + printList[0] + '][key]')[0].value;

            return printRaw(tradesperson, reqnum, key);
        }

        function printRaw(name, partnum, key) {
            try {
                var labelXml = '<DieCutLabel Version="8.0" Units="twips" MediaType="Durable">\
                    <PaperOrientation>Landscape</PaperOrientation>\
                    <Id>LW_DURABLE_25X89mm</Id>\
                    <IsOutlined>false</IsOutlined>\
                    <PaperName>1933081 Drbl 1 x 3-1/2 in</PaperName>\
                    <DrawCommands>\
                        <RoundRectangle X="0" Y="0" Width="1440" Height="5040" Rx="90.708661417" Ry="90.708661417" />\
                    </DrawCommands>\
                    <ObjectInfo>\
                        <TextObject>\
                            <Name>title</Name>\
                            <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                            <LinkedObjectName />\
                            <Rotation>Rotation0</Rotation>\
                            <IsMirrored>False</IsMirrored>\
                            <IsVariable>False</IsVariable>\
                            <GroupID>-1</GroupID>\
                            <IsOutlined>False</IsOutlined>\
                            <HorizontalAlignment>Center</HorizontalAlignment>\
                            <VerticalAlignment>Top</VerticalAlignment>\
                            <TextFitMode>ShrinkToFit</TextFitMode>\
                            <UseFullFontHeight>True</UseFullFontHeight>\
                            <Verticalized>False</Verticalized>\
                            <StyledText>\
                                <Element>\
                                    <String xml:space="preserve">' + name + '</String>\
                                    <Attributes>\
                                        <Font Family="Arial" Size="24" Bold="True" Italic="False" Underline="False" Strikeout="False" />\
                                        <ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />\
                                    </Attributes>\
                                </Element>\
                            </StyledText>\
                        </TextObject>\
                        <Bounds X="330" Y="71.9999999999999" Width="4320" Height="585" />\
                    </ObjectInfo>\
                    <ObjectInfo>\
                        <BarcodeObject>\
                            <Name>BARCODE</Name>\
                            <ForeColor Alpha="255" Red="0" Green="0" Blue="0" />\
                            <BackColor Alpha="0" Red="255" Green="255" Blue="255" />\
                            <LinkedObjectName />\
                            <Rotation>Rotation0</Rotation>\
                            <IsMirrored>False</IsMirrored>\
                            <IsVariable>True</IsVariable>\
                            <GroupID>-1</GroupID>\
                            <IsOutlined>False</IsOutlined>\
                            <Text>' + partnum + '-' + key + '</Text>\
                            <Type>Code39</Type>\
                            <Size>Medium</Size>\
                            <TextPosition>Bottom</TextPosition>\
                            <TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                            <CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />\
                            <TextEmbedding>None</TextEmbedding>\
                            <ECLevel>0</ECLevel>\
                            <HorizontalAlignment>Center</HorizontalAlignment>\
                            <QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />\
                        </BarcodeObject>\
                        <Bounds X="330" Y="813" Width="4620" Height="555" />\
                    </ObjectInfo>\
                </DieCutLabel>';

                var label = dymo.label.framework.openLabelXml(labelXml);

                // select printer to print on
                // for simplicity sake just use the first LabelWriter printer
                var printers = dymo.label.framework.getPrinters();
                if (printers.length == 0)
                    throw "No DYMO printers are installed. Install DYMO printers.";

                var printerName = "";
                for (var i = 0; i < printers.length; ++i) {
                    var printer = printers[i];
                    if (printer.printerType == "LabelWriterPrinter") {
                        printerName = printer.name;
                        break;
                    }
                }

                if (printerName == "")
                    throw "No LabelWriter printers found. Install LabelWriter printer";

                // finally print the label
                label.print(printerName);
            }
            catch (e) {
                alert(e.message || e);
                return false;
            }

            return true;
        }
    </script>
@endsection