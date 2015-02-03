@extends('layouts.lte')

@section('content')

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    @include('pages.sales-invoices.print')
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box-foot pull-right">
                                <a href="{{url("sales-invoices/{$salesInvoice->document_number}/print")}}" target="_blank" class="btn btn-success action-button">Print</a>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>

@endsection