
<div class="row">

    <div class="col-xs-12">
        <legend>
            <i class="fa fa-motorcycle fa-2x text-red"></i>
            A.R.C Motorcycles Invoice
            <span class="pull-right">
                Number {{$salesInvoice->document_number}}
            </span>
        </legend>
    </div>

    <div class="col-xs-6">
        <legend>Customer Information</legend>
        <table class="table table-striped">
            <tr>
                <th>Sold To:</th>
                <td>{{$salesInvoice->issuedTo->full_name}}</td>
            </tr>
            <tr>
                <th>Contact Number 1:</th>
                <td>{{$salesInvoice->issuedTo->contact_number_1}}</td>
            </tr>
            <tr>
                <th>Contact Number 2:</th>
                <td>{{$salesInvoice->issuedTo->contact_number_2}}</td>
            </tr
            <tr>
                <th>Landline Number:</th>
                <td>{{$salesInvoice->issuedTo->landline_number}}</td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>{{$salesInvoice->issued_to_address}}</td>
            </tr>
        </table>
    </div>

    <div class="col-xs-6">
        <legend>Invoice Information</legend>
        <table class="table table-striped">
            <tr>
                <th>Date Issued / Document Date:</th>
                <td>{{$salesInvoice->document_date}}</td>
            </tr>
            <tr>
                <th>Down Payment:</th>
                <td>{{number_format($salesInvoice->down_payment)}}</td>
            </tr>
            <tr>
                <th>Invoice Status:</th>
                <td>{{$salesInvoice->status}}</td>
            </tr>
            <tr>
                <th>Issued By</th>
                <td>{{$salesInvoice->issuedBy->display_name}} ({{$salesInvoice->issuedBy->role_name}})</td>
            </tr>
            <tr>
                <th>Remarks:</th>
                <td>{{$salesInvoice->remarks}}</td>
            </tr>         
        </table>
    </div>

    <div class="col-xs-12">

        <legend>Invoice Details</legend>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Name</th>
                    <th>Unit Cost</th>
                    <th>Qty Sold</th>
                    <th>Sub Total</th>
                </tr>
            </thead>            
            <tbody>
                @foreach($salesInvoice->details AS $detail)
                <tr>
                    <td>{{$detail->item_model}}</td>
                    <td>{{$detail->item_name}}</td>
                    <td>{{number_format($detail->item_cost)}}</td>
                    <td>{{$detail->item_qty}}</td>
                    <td>{{number_format($detail->sub_total)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <span class="pull-right">Total: </span>
                    </th>
                    <th>
                        {{number_format($salesInvoice->total_amount)}}
                    </th>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
