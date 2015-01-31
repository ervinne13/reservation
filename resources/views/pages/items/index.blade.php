@extends('layouts.lte-record-list')

@section('js')
@parent

<script type="text/javascript">
    var status = "{{$status}}";
</script>

<script src="{{ asset ("/js/pages/items/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Items Master Files
        @if ($status)
        <small><a href="{{url("/items")}}">Back to all Items</a></small>
        @endif
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
                                        <th style="min-width: 40px">
                                            <a class="action-create-entry" href="/items/create">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>                                        
                                        <th>Model</th>                                        
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Item Cost</th>
                                        <th>Remaining Stocks</th>
                                        <th>Committed Stocks</th>
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