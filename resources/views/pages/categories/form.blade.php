@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$category->id}}';
    var mode = '{{$mode}}';
</script>

<script src="{{ asset ("/js/pages/categories/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Category
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
                                    <input type="text" required name="name" class="form-control required" value="{{ $category->name }}" placeholder="Ex. Scooter">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea required class="form-control required" name="description" style="min-height: 250px;">{{ $category->description }}</textarea>
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