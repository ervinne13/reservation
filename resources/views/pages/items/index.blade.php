@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/items/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Items Master Files
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
                                            <a href="/sales-invoices/create">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>                                        
                                        <th>Doc No.</th>
                                        <th>Doc Date</th>
                                        <th>Invoice Amount</th>
                                        <th>Issued To</th>
                                        <th>Remarks</th>
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