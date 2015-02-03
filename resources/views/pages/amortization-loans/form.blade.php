@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var docNo = '{{$aml->document_number}}';
    var mode = '{{$mode}}';
    var details = '{!! json_encode($aml->details) !!}';
</script>

<script src="{{ asset ("/js/pages/amortization-loans/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Amortization Loan
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
                                    <input type="text" required readonly name="document_number" class="form-control required" value="{{ $aml->document_number }}">
                                </div>

                                <div class="form-group">
                                    <label>Document Date</label>
                                    <input type="text" required readonly name="document_date" class="form-control required" value="{{ $aml->document_date }}">
                                </div>

                                <div class="form-group">
                                    <label>Reference Invoice</label>
                                    <select name="reference_invoice_number" class="form-control">
                                        <option selected disabled></option>
                                        @foreach($openInvoices AS $invoice)
                                        <?php $selected = $invoice->document_number == $aml->reference_invoice_number ? "selected" : "" ?>
                                        <option 
                                            value="{{$invoice->document_number}}" 
                                            {{$selected}} 
                                            data-terms="{{$invoice->reservation ? $invoice->reservation->terms : NULL}}"
                                            data-issued-to-username="{{$invoice->issued_to_username}}"
                                            data-invoice-amount="{{$invoice->total_amount}}"
                                            data-invoice-down-payment="{{$invoice->down_payment}}"
                                            >
                                        <b>{{$invoice->document_number}}</b> ({{$invoice->issued_to_name}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Loan By</label>
                                    <input type="text" required readonly name="loan_by_username" class="form-control required" value="{{ $aml->loan_by_username }}" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label>Loan Amount</label>
                                    <input type="text" required readonly name="loan_amount" class="form-control required autonumeric" value="{{ $aml->loan_amount }}" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Remaining Amount</label>
                                    <input type="text" required readonly name="remaining_amount" class="form-control required autonumeric" value="{{ $aml->remaining_amount }}" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Number of Months to Pay</label>
                                    <input type="number" required name="months_to_pay" class="form-control required" value="{{ $aml->months_to_pay }}" placeholder="xx">
                                </div>                               
                                
                            </div>
                            <div class="col-lg-6 col-sm-12">

                                <div class="form-group">
                                    <label>Date Received</label>
                                    <input type="text" required name="date_received" class="form-control required datepicker" value="{{ $aml->date_received }}" placeholder="xxxx-xx-xx">
                                </div>

                                <div class="form-group">
                                    <label>Annual Interest Rate</label>
                                    <input type="number" required name="annual_interest_rate" class="form-control required" value="{{ $aml->annual_interest_rate }}" placeholder="x.xxx">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Prevailing Interest Rate
                                        <small>(For Reference Only)</small>
                                    </label>
                                    <input type="number" name="prevailing_interest_rate" class="form-control" value="{{ $aml->prevailing_interest_rate }}" placeholder="x.xxx">
                                </div>

                                <div class="form-group">
                                    <label>Estimated Monthly Principal</label>
                                    <input type="text" required readonly name="estimated_monthly_principal" class="form-control required autonumeric" value="{{ $aml->estimated_monthly_principal }}" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Estimated Monthly Interest</label>
                                    <input type="text" required readonly name="estimated_monthly_interest" class="form-control required autonumeric" value="{{ $aml->estimated_monthly_interest }}" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control" placeholder="Fill in for any remarks for this transaction">{{ $aml->remarks }}</textarea>
                                </div>                               
                            </div>
                        </div>
                    </form>

                </div><!-- ./box-body -->
                <div class="box-footer">
                    @include('module.parts.actions')
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection