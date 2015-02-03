@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/form-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/reservations/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Client Reservations
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
                                        <th></th>
                                        <th>Reserved By</th>
                                        <th>Reserved By Contact</th>
                                        <th>Status</th>
                                        <th>Item To Reserve</th>
                                        <th>Qty To Reserve</th>
                                        <th>Reservation Amount (Per Item)</th>
                                        <th>Total Amount</th>
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