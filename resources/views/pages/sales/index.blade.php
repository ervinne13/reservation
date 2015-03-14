@extends('layouts.lte-record-list')

@section('js')
@parent

<script src="{{ asset ("/vendor/underscore/underscore.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/vendor/jquery/jquery.validate.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/form-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table-row-utilities.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/js/pages/sales.js") }}" type="text/javascript"></script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sales & Collections
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>Monthly Sales</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="sales-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>                                        
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th class="text-right">Sales for the Period</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($monthlySales AS $sales)
                                    <tr>
                                        <td></td>
                                        <td>{{$sales->sales_year}}</td>
                                        <td>{{date('F', mktime(0, 0, 0, $sales->sales_month, 10))}}</td>
                                        <td class="text-right">{{number_format($sales->total_sales, 2)}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->            
        </div>

        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>Monthly Collections</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="collections-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>                                        
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th class="text-right">Collections for the Period</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyCollections AS $collections)
                                    <tr>
                                        <td></td>
                                        <td>{{$collections->collection_year}}</td>
                                        <td>{{date('F', mktime(0, 0, 0, $collections->collection_month, 10))}}</td>
                                        <td class="text-right">{{number_format($collections->total_collections, 2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->            
        </div>

        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4>Daily Sales (Up to Last 30 Sales Day)</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="sales-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th class="text-right">Sales for the Period</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($dailySales AS $sales)
                                    <tr>
                                        <td></td>                                        
                                        <td>{{date_format (new \DateTime($sales->document_date) , "M d, Y" )}}</td>
                                        <td class="text-right">{{number_format($sales->total_sales, 2)}}</td>
                                    </tr>
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