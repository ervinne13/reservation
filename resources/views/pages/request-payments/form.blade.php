@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var docNo = '{{$rp->document_number}}';
    var mode = '{{$mode}}';
    var details = '{!! json_encode($rp->details) !!}';
</script>

@include('pages.request-payments.detail-form-templates')
@include('templates.default-dropdown-table-actions')

<script src="{{ asset ("/js/sg-table.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table-row-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/request-payments/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Request Payment
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
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label>Document Number</label>
                                    <input type="text" required readonly name="document_number" class="form-control required" value="{{ $rp->document_number }}">
                                </div>

                                <div class="form-group">
                                    <label>Document Date</label>
                                    <input type="text" required readonly name="document_date" class="form-control required" value="{{ $rp->document_date }}">
                                </div>

                                <div class="form-group">
                                    <label>Due Date</label>
                                    <input type="text" required name="due_date" class="form-control required datepicker" value="{{ $rp->due_date }}" placeholder="xxxx-xx-xx">
                                </div>                                

                                <div class="form-group">
                                    <label>Applies to Loan:</label>
                                    <select required name="applies_to" class="form-control required" value="{{ $rp->applies_to }}">
                                        <option disabled selected></option>                                        
                                        @foreach($amortizationDocumentList AS $aml)
                                        <?php $selected = $rp->applies_to == $aml->document_number ? "selected" : "" ?>
                                        <option 
                                            value="{{$aml->document_number}}"                                             
                                            data-annual-interest-rate="{{$aml->annual_interest_rate}}"
                                            data-prevailing-interest-rate="{{$aml->prevailing_interest_rate}}"
                                            data-loan-amount="{{$aml->loan_amount}}"
                                            data-remaining-amount="{{$aml->remaining_amount}}"
                                            data-estimated-monthly-principal="{{$aml->estimated_monthly_principal}}"
                                            data-estimated-monthly-interest="{{$aml->estimated_monthly_interest}}" 
                                            {{$selected}}>
                                            {{$aml->document_number}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Total Payment</label>
                                    <input type="text" required readonly name="total_payment" class="form-control autonumeric required" value="{{ $rp->total_payment }}" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control" placeholder="Fill in for any remarks for this transaction">{{ $rp->remarks }}</textarea>
                                </div>

                            </div>                            
                            <div class="col-lg-4 col-sm-12">

                                <div class="form-group">
                                    <label>Loan Annual Interest Rate</label>
                                    <input type="text" readonly name="aml_annual_interest_rate" class="form-control" placeholder="x.xxx">
                                </div>

                                <div class="form-group">
                                    <label>Loan Prevailing Interest Rate</label>
                                    <input type="text" readonly name="aml_prevailing_interest_rate" class="form-control" placeholder="x.xxx">
                                </div>

                                <div class="form-group">
                                    <label>Loan Amount</label>
                                    <input type="text" readonly name="aml_loan_amount" class="form-control autonumeric" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Remaining Amount</label>
                                    <input type="text" readonly name="aml_remaining_amount" class="form-control autonumeric" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Estimated Monthly Principal</label>
                                    <input type="text" readonly name="aml_estimated_monthly_principal" class="form-control autonumeric" placeholder="00,000.00">
                                </div>

                                <div class="form-group">
                                    <label>Estimated Monthly Interest</label>
                                    <input type="text" readonly name="aml_estimated_monthly_interest" class="form-control autonumeric" placeholder="00,000.00">
                                </div>

                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label>Issued By</label>
                                    <input type="text" readonly required name="issued_by_username" class="form-control required" value="{{ $rp->issued_by_username }}">
                                </div>

                                <div class="form-group">
                                    <label>Payment by User</label>
                                    <select required name="payment_by_username" class="form-control required" value="{{ $rp->payment_by_username }}">
                                        @foreach($clients AS $client)
                                        <?php $selected = $rp->payment_by_username == $client->username ? "selected" : "" ?>
                                        <option value="{{$client->username}}" data-full-name="{{$client->full_name}}" data-address="{{$client->address}}">
                                            {{$client->username}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Issued To (Full Name)</label>
                                    <input type="text" readonly required name="payment_by_name" class="form-control required" value="{{ $rp->payment_by_name }}">
                                </div>

                                <div class="form-group">
                                    <label>Issued To Address</label>
                                    <textarea required name="payment_by_address" class="form-control required">{{ $rp->payment_by_address }}</textarea>
                                </div>

                            </div>
                        </div>
                    </form>

                    <hr>

                    <legend>Payment Details</legend>

                    <table id="tbl-details" class="table table-striped dropdown-table"></table>

                </div><!-- ./box-body -->
                <div class="box-footer">

                    @if($mode == "ADD")
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box-foot pull-right">
                                <button id="action-create-new" type="button" class="btn btn-success action-button">Create And New</button>
                                <button id="action-create-close" type="button" class="btn btn-primary action-button">Create And Close</button>
                                <button id="action-save-and-post" type="button" class="btn btn-warning post-button">Create And Post</button>
                            </div>
                        </div>
                    </div>
                    @elseif ($mode == "EDIT")
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box-foot pull-right">                
                                <button id="action-update-close" type="button" class="btn btn-primary action-button">Update And Close</button>
                                <button id="action-post" type="button" class="btn btn-warning post-button">Post</button>
                            </div>
                        </div>
                    </div>
                    @elseif ($mode == "VIEW")
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box-foot pull-right">
                                <button id="action-post" type="button" class="btn btn-warning post-button">Post</button>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection