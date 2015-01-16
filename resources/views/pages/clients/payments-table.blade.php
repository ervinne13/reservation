
<legend>Payments Made</legend>

@foreach($client->loans AS $loan)

<label>Payment for {{$loan->document_number}} amounting to {{$loan->loan_amount}}</label>

<table class="table table-striped table-hover">

    <thead>
        <tr>            
            <th>Payment No.</th>            
            <th>Loan No.</th>
            <th>Date of Payment</th>
            <th>Total Payment</th>            
            <th>Payment For Principal</th>            
            <th>Remaining Balance</th>            
        </tr>
    </thead>
    <tbody>
        @foreach($loan->details AS $detail)
        <tr>                       
            <td>
                <a href="{{url("request-payments/" . $detail->payment_document_number)}}">
                    <i class="fa fa-search"></i>
                    {{$detail->payment_document_number}}
                </a>
            </td>
            <td>
                <a href="{{url("amortization-loans/" . $detail->document_number)}}">
                    <i class="fa fa-search"></i>
                    {{$detail->document_number}}
                </a>
            </td>            
            <td>{{$detail->payment_date}}</td>
            <td>{{number_format($detail->payment_amount, 2)}}</td>
            <td>{{number_format($detail->principal_payment, 2)}}</td>
            <td>{{number_format($detail->running_balance, 2)}}</td>
        </tr>

        <?php $lastPaymentMadeString = $detail->payment->document_date ?>

        @endforeach
    </tbody>

</table>

<?php
$lastPaymentMade       = strtotime($lastPaymentMadeString);
$nextPaymentDate       = date("Y-m-d", strtotime("+1 month", $lastPaymentMade));
?>

<label>Next payment date: {{$nextPaymentDate}}</label>

@endforeach
