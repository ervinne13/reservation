
<div class="row">

    <div class="col-xs-12">
        <legend>
            Amortization Loan            
            <span class="pull-right">
                Number {{$aml->document_number}}
            </span>
        </legend>
    </div>

    <div class="col-xs-6">
        <legend>Customer Information</legend>
        <table class="table table-striped">
            <tr>
                <th>Loan By:</th>
                <td>{{$aml->loanBy->full_name}}</td>
            </tr>
            <tr>
                <th>Contact Number 1:</th>
                <td>{{$aml->loanBy->contact_number_1}}</td>
            </tr>
            <tr>
                <th>Contact Number 2:</th>
                <td>{{$aml->loanBy->contact_number_2}}</td>
            </tr
            <tr>
                <th>Landline Number:</th>
                <td>{{$aml->loanBy->landline_number}}</td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>{{$aml->issued_to_address}}</td>
            </tr>
        </table>
    </div>

    <div class="col-xs-6">
        <legend>Loan Information</legend>
        <table class="table table-striped">
            <tr>
                <th>Date Received:</th>
                <td>{{$aml->date_received}}</td>
            </tr>
            <tr>
                <th>Invoice:</th>
                <td>
                    <a href="/sales-invoices/{{$aml->reference_invoice_number}}">
                        {{$aml->reference_invoice_number}}
                    </a>
                </td>
            </tr>
            <tr>
                <th>Loan Amount:</th>
                <td>{{number_format($aml->loan_amount, 2)}}</td>
            </tr>
            <tr>
                <th>Remaining Amount:</th>
                <td>{{number_format($aml->remaining_amount, 2)}}</td>
            </tr>            
            <tr>
                <th>Remarks:</th>
                <td>{{$aml->remarks}}</td>
            </tr>         
        </table>
    </div>

    <div class="col-xs-12">

        <legend>Loan Payments</legend>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ref. No.</th>
                    <th>Payment Amount</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Penalty</th>
                    <th>Running Balance</th>
                </tr>
            </thead>            
            <tbody>
                @foreach($aml->details AS $detail)
                <tr>
                    <td>{{$detail->payment_document_number}}</td>
                    <td>{{$detail->payment_amount}}</td>
                    <td>{{$detail->principal_payment}}</td>
                    <td>{{$detail->interest_payment}}</td>
                    <td>{{$detail->penalty_payment}}</td>
                    <td>{{number_format($detail->running_balance, 2)}}</td>
                </tr>
                @endforeach
            </tbody>           
        </table>

    </div>

</div>
