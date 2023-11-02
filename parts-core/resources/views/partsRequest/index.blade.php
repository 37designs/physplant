@extends('layouts.master')

@section('title') Request Parts @endsection

@section('content')
    <div class="container">

        <form class="well form-horizontal" action="{{ URL::route('partsrequest') }}" method="post" id="contact_form">

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
                <legend style="text-align: center; font-size: 25px;">Request Parts</legend>

                <!-- Technician -->
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 control-label">Technician</label>
                    <div class="col-md-4 col-sm-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="tech" required="" value="{{ \App\Technician::find(old('tech')) }}"
                                    class="form-control selectpicker">
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}"
                                            @if($technician->id == old('tech')) selected @endif>{{ $technician->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Work Order -->
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 control-label">Work Order #</label>
                    <div class="col-md-4 col-sm-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                            <input autocomplete="off" class="form-control" name="wo" placeholder="X-12345678"
                                   type="text"
                                   pattern="([xX]-)[0-9]{8}" required="" value="{{ old('wo') }}" maxlength="10">
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div class="form-group">
                    <label class="col-md-4 col-sm-4 control-label">Comments</label>
                    <div class="col-md-4 col-sm-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            <textarea autocomplete="off" class="form-control" name="comments"
                                      placeholder="Any order description">{{ old('comments') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Parts -->
                <legend style="font-size: 20px">Parts</legend>
                <div id="parts-wrapper" style="margin: 0 0 0 0;">
                </div>
                <button class="btn btn-primary add" type="button" style="margin-bottom: 10px;">Add line</button>
                <button class="btn btn-danger remove" type="button" style="margin-bottom: 10px;">Remove line</button>

                <button name="submit" class="btn col-md-12 btn-success btn-lg" id="submit-btn">
                    Submit
                    <span class="glyphicon glyphicon-send"></span>
                </button>

                <span class="msg text-danger"></span>
            </fieldset>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var count = 0;
            var $targetDiv = $("div#parts-wrapper");

            function addRow() {
                $targetDiv.append('<div class="form-group">'
                    + '<div class="col-sm-1 col-sm-1 inputGroupContainer nopadding">'
                    + '<input name="parts[' + count + '][quantity]" placeholder="Qty" class="form-control" type="text" autocomplete="off" required></div>'
                    + '<div class="col-sm-2 col-sm-2 inputGroupContainer nopadding">'
                    + '<input name="parts[' + count + '][part_num]" placeholder="Part Number" class="form-control" type="text" autocomplete="off"></div>'
                    + '<div class="col-sm-2 col-sm-2 inputGroupContainer nopadding">'
                    + '<input name="parts[' + count + '][vendor]" list="vendors" class="form-control" type="text" placeholder="Vendor" autocomplete="off" required></div>'
                    + '<div class="col-sm-5 col-sm-5 inputGroupContainer nopadding">'
                    + '<input name="parts[' + count + '][description]" placeholder="Part Description" class="form-control" type="text" autocomplete="off"></div>'
                    + '<div class="col-sm-2 col-sm-2 inputGroupContainer nopadding">'
                    + '<div class="input-group"><span class="input-group-addon">Expedite?</span>'
                    + '<select name="parts[' + count + '][expedite]" class="form-control" title="Expedite?">'
                    + '<option value="0">No</option>'
                    + '<option value="1">Yes</option>'
                    + '</select></div>'
                    + '</div>');
                count++;
            }

            $("button.add").click(addRow);

            $("button.remove").click(function () {
                if (count > 1) {
                    $targetDiv.find('.form-group').last().remove();
                    $("span.msg").text('');
                    count--;
                }
            });

            @if ( null === old('parts'))
            addRow();
            @endif

            
            
            @for ($i = 0; (!empty(old('parts'))) && ($i < sizeof(old('parts'))); $i++)
            addRow();
            
            $("input[name='parts[{{ $i }}][quantity]']").val('{{ old('parts.' . $i . '.quantity') }}');
            $("input[name='parts[{{ $i }}][part_num]']").val('{{ old('parts.' . $i . '.part_num') }}');
            $("input[name='parts[{{ $i }}][vendor]']").val('{{ old('parts.' . $i . '.vendor') }}');
            $("input[name='parts[{{ $i }}][description]']").val('{{ old('parts.' . $i . '.description') }}');
            $("select[name='parts[{{ $i }}][expedite]']").val('{{ old('parts.' . $i . '.expedite') }}');
            
            @endfor
           
        
        });
    </script>
@endsection

@section('footer')
    <datalist id="vendors">
        @foreach ($vendors as $vendor)
            <option value="{{ $vendor->name }}">
        @endforeach
    </datalist>

    <style>
        .nopadding {
            padding: 2px !important;
            margin: 0 !important;
        }
    </style>
@endsection