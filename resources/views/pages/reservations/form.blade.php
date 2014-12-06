@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var docNo = '{{$salesInvoice->document_number}}';
    var mode = '{{$mode}}';
    var details = '{!! json_encode($salesInvoice->details) !!}';
</script>

@include('pages.sales-invoices.detail-form-templates')
@include('templates.default-dropdown-table-actions')

<script src="{{ asset ("/js/sg-table.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table-row-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/sales-invoices/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sales Invoice
        <small>
            {{ ($mode == "ADD" ? "Create New" : "Update") }}
        </small>       
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="fields-container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Document Number</label>
                                    <input type="text" required readonly name="document_number" class="form-control required" value="{{ $salesInvoice->document_number }}">
                                </div>

                                <div class="form-group">
                                    <label>Document Date</label>
                                    <input type="text" required readonly name="document_date" class="form-control required" value="{{ $salesInvoice->document_date }}">
                                </div>

                                <div class="form-group">
                                    <label>Invoice Amount</label>
                                    <input type="number" required readonly name="total_amount" class="form-control required" value="{{ $salesInvoice->total_amount }}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Down Payment
                                        <small>For fully paid motorcycles, enter the full amount here</small>
                                    </label>
                                    <input type="number" name="down_payment" class="form-control" value="{{ $salesInvoice->down_payment }}">
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control">{{ $salesInvoice->remarks }}</textarea>
                                </div>

                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Issued By</label>
                                    <input type="text" readonly required name="issued_by_username" class="form-control required" value="{{ $salesInvoice->issued_by_username }}">
                                </div>

                                <div class="form-group">
                                    <label>Issued To</label>
                                    <select required name="issued_to_username" class="form-control required" value="{{ $salesInvoice->issued_to_username }}">
                                        @foreach($clients AS $client)
                                        <?php $selected = $salesInvoice->issued_to_username == $client->username ? "selected" : "" ?>
                                        <option value="{{$client->username}}" data-full-name="{{$client->full_name}}" data-address="{{$client->address}}">
                                            {{$client->username}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Issued To (Full Name)</label>
                                    <input type="text" readonly required name="issued_to_name" class="form-control required" value="{{ $salesInvoice->issued_to_name }}">
                                </div>

                                <div class="form-group">
                                    <label>Issued To (Full Name)</label>
                                    <textarea required name="issued_to_address" class="form-control required">{{ $salesInvoice->issued_to_address }}</textarea>
                                </div>

                            </div>
                        </div>
                    </form>

                    <hr>

                    <legend>Sales Invoice Details</legend>

                    <table id="tbl-details" class="table table-striped dropdown-table"></table>

                </div><!-- ./box-body -->
                <div class="box-footer">
                    @include('module.parts.actions')
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection