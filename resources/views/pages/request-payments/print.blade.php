
<div class="row">

    <div class="col-xs-12">
        <legend>
            <i class="fa fa-motorcycle fa-2x text-red"></i>
            A.R.C Motorcycles Payment Information
            <span class="pull-right">
                Number {{$requestPayment->document_number}}
            </span>
        </legend>
    </div>

    <div class="col-xs-6">
        <legend>Customer Information</legend>
        <table class="table table-striped">
            <tr>
                <th>Payent By:</th>
                <td>{{$requestPayment->paymentBy->full_name}}</td>
            </tr>
            <tr>
                <th>Contact Number 1:</th>
                <td>{{$requestPayment->paymentBy->contact_number_1}}</td>
            </tr>
            <tr>
                <th>Contact Number 2:</th>
                <td>{{$requestPayment->paymentBy->contact_number_2}}</td>
            </tr
            <tr>
                <th>Landline Number:</th>
                <td>{{$requestPayment->paymentBy->landline_number}}</td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>{{$requestPayment->issued_to_address}}</td>
            </tr>
        </table>
    </div>

    <div class="col-xs-6">
        <legend>Payment Information</legend>
        <table class="table table-striped">
            <tr>
                <th>Date Issued / Document Date:</th>
                <td>{{$requestPayment->document_date}}</td>
            </tr>
            <tr>
                <th>Total Payment:</th>
                <td>{{number_format($requestPayment->total_payment, 2)}}</td>
            </tr>
            <tr>
                <th>Payment Status:</th>
                <td>{{$requestPayment->status}}</td>
            </tr>
            <tr>
                <th>Remarks:</th>
                <td>{{$requestPayment->remarks}}</td>
            </tr>         
        </table>
    </div>

    <div class="col-xs-12">

        <legend>Payment Details</legend>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Payment For</th>
                    <th style="text-align: right">Payment</th>
                    <th style="min-width: 280px;">Remarks</th>
                </tr>
            </thead>            
            <tbody>
                @foreach($requestPayment->details AS $detail)
                <tr>
                    <td>{{$detail->payment_type_code}}</td>
                    <td style="text-align: right">{{number_format($detail->amount, 2)}}</td>                    
                    <td>{{$detail->comment}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>
                        <span class="pull-right">Total: </span>
                    </th>
                    <th style="text-align: right">
                        {{number_format($requestPayment->total_payment)}}
                    </th>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
