@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/amortization-loans/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Amortization Loans
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <a class="action-create-entry" href="/amortization-loans/create">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>
                                        <th>Doc No.</th>
                                        <th>Doc Date</th>
                                        <th>Ref. Invoice No.</th>
                                        <th>Loan By</th>
                                        <th>Loan Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Date Received</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection