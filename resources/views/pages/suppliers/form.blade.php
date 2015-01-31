@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$supplier->id}}';
    var mode = '{{$mode}}';
</script>

<script src="{{ asset ("/js/pages/suppliers/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Supplier
        <small>
            {{ ($mode == "ADD" ? "Create New" : "Update") }}
        </small>       
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="fields-container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">                
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control required" value="{{ $supplier->name }}" placeholder="Ex. Racal">
                                </div>
                            </div>

                        </div>

                    </form>

                </div><!-- ./box-body -->
                <div class="box-footer">
                    @include('module.parts.actions')
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection