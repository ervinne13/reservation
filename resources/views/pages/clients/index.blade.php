@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/form-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/clients/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Clients        
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
                                            <a class="action-create-entry" href="/clients/create">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>                                        
                                        <th>Username</th>
                                        <th>Delinquent?</th>
                                        <th>Name</th>
                                        <th>Contact Number 1</th>
                                        <th>Contact Number 2</th>
                                        <th>Landline</th>
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