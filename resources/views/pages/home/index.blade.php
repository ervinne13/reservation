@extends('layouts.lte-record-list')

@section('js')
@parent

@include('pages.home.settings-tables-form-templates')
@include('templates.default-dropdown-table-actions')

<script type="text/javascript">
    var phoneNumbers = {!! $phoneNumbers !!}
    ;
            var bankAccounts = {!! $bankAccounts !!}
    ;
</script>

<script src="{{ asset ("/vendor/underscore/underscore.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/vendor/jquery/jquery.validate.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/form-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table-row-utilities.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/sg-table-row-utilities.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/js/pages/dashboard.js") }}" type="text/javascript"></script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Administrator Dashboard
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">System Settings: Phone Numbers</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>
                </div>
                <div class="box-body">

                    <small>These numbers will be notified about each action taken in the system</small>

                    <table class="table table-striped" id="tbl-phone-numbers">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Number</th>
                                <th>Owner Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div><!-- /.box -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">System Settings: Bank Accounts</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <small>These accounts will be displayed in the client's mobile devices when they issue a reservation</small>

                            <table class="table table-striped" id="tbl-bank-accounts">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div><!-- /.box -->

        </div>

        <div class="col-lg-6">

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Sales & Collections</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped" >
                        <tbody>
                            <tr>                                
                                <td>Total Sales & Collections For 2016</td>
                                <td>P<span id="current-year-sales">{{number_format($salesSummary["total_sales"], 2)}}</span></td>
                            </tr>
                            <tr>                                
                                <td>Total <b>New</b> Sales For <span class="current-month">December</span></td>
                                <td>P<span id="current-month-sales">{{number_format($salesSummary["month_sales"], 2)}}</span></td>
                            </tr>
                            <tr>                                
                                <td>Total Collections For <span class="current-month">December</span></td>
                                <td>P<span id="current-month-collections">{{number_format($salesSummary["total_collections"], 2)}}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->

            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Inventory Status</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped" >
                        <tbody>
                            <tr>                                
                                <td>Items <b class="text-green">In Stock</b></td>
                                <td>{{$itemsSummary["with_stocks"]}} Item(s), <a href="/items/status/In Stock">View</a></td>
                            </tr>
                            <tr>                                
                                <td>Items <b>Low in Stock</b></td>
                                <td>{{$itemsSummary["critical_items"]}} Item(s), <a href="/items/status/Low Stocks">View</a></td>
                            </tr>
                            <tr>                                
                                <td>Items Out of Stock</td>
                                <td>{{$itemsSummary["out_of_stock_items"]}} Item(s), <a href="/items/status/Out of Stock">View</a></td>
                            </tr>
                            <tr>      
                                @if ($itemsSummary["committed_stocks"] > 0)
                                <td><b class="text-danger">Committed Stocks</b></td>
                                @else
                                <td>Committed Stocks</td>
                                @endif                                
                                <td>{{$itemsSummary["committed_stocks"]}} Item(s), <a href="/items/status/Committed Stocks">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Reservations By Client</h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped" >
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Reserved Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientReservations AS $clientReservation)
                            <tr>
                                <td>{{$clientReservation->client_name}}</td>
                                <td>{{$clientReservation->reservation_count}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <a href="{{url("/reservations")}}">View All Reservations</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- /.box -->

        </div>

    </div>

</section><!-- /.content -->
@endsection