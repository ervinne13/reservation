@extends('layouts.lte')

@section('content')

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    @include('pages.sales-invoices.print')
                </div>
            </div>
        </div>
    </div>
</section>

@endsection