@extends('layouts.lte-record-list')

@section('js')
@parent

<script src="{{ asset ("/vendor/underscore/underscore.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/vendor/jquery/jquery.validate.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/form-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table-row-utilities.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/js/pages/overde-customers.js") }}" type="text/javascript"></script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Overdue Customers
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">                
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="sales-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>                                        
                                        <th>Loan Document Number</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th class="text-right">Estimated Monthly</th>
                                        <th class="text-right">Remaining Amount</th>                                        
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $currentDate = new DateTime() ?>

                                    @foreach($openLoans AS $loan)

                                    @if($loan->getCurrentDueDate() < $currentDate)
                                    <tr>
                                        <td></td>
                                        <td>{{$loan->document_number}}</td>
                                        <td><a href="{{url("clients/" . $loan->loanBy->username . "/edit")}}">{{$loan->loanBy->full_name}}</a></td>
                                        <td>{{$loan->getCurrentDueDate()->format("Y-m-d")}}</td>
                                        <td class="text-right">{{number_format($loan->estimated_monthly_principal + $loan->estimated_monthly_interest, 2)}}</td>
                                        <td class="text-right">{{number_format($loan->remaining_amount, 2)}}</td>                                        
                                    </tr>
                                    @endif

                                    @endforeach

                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->                    
        </div>
    </div>


</section><!-- /.content -->
@endsection