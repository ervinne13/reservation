@extends('layouts.lte-module')

@section('css')
@parent
<link href="{{ asset("/vendor/dropzone/dropzone.css")}}" rel="stylesheet" type="text/css" />

<style>
    .dz-image img {
        width: 100%;
        height: 100%;
    }
</style>

@endsection

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$item->id}}';
    var mode = '{{$mode}}';
</script>

<script src="{{ asset ("/vendor/dropzone/dropzone.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/js/image-utils.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/items/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Item Master File
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
                                    <label>Model Number</label>
                                    <input type="text" required name="model" class="form-control required" value="{{ $item->model }}" placeholder="xxx-xxxx">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control required" value="{{ $item->name }}" placeholder="Ex. Racal TS125">
                                </div>

                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="text" required name="cost" class="form-control required" value="{{ $item->cost }}" placeholder="xx,xxx.xx">
                                </div>

                                <div class="form-group">
                                    <!--<label>Reservation Cost</label>-->
                                    <label>Downpayment</label>
                                    <input type="text" required name="reservation_cost" class="form-control required" value="{{ $item->reservation_cost }}" placeholder="xx,xxx.xx">
                                </div>

                            </div>
                            <div class="col-lg-6 col-sm-12">

                                <!--<div class="form-group">
                                                                    <label>Engine Type</label>
                                                                    <input type="text" name="engine_type" class="form-control" value="{{ $item->engine_type }}">
                                                                </div>
                                
                                                                <div class="form-group">
                                                                    <label>Engine Stroke</label>
                                                                    <input type="text" name="engine_stroke" class="form-control" value="{{ $item->engine_stroke }}">
                                                                </div>
                                
                                                                <div class="form-group">
                                                                    <label>Oil Capacity</label>
                                                                    <input type="text" name="oil_capacity" class="form-control" value="{{ $item->oil_capacity }}">
                                                                </div>-->

                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category">
                                        @foreach($categories AS $category)
                                        <?php $selected = $category == $item->category ? "selected" : "" ?>
                                        <option value="{{$category}}" {{$selected}}>{{$category}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>

                                <div class="form-group">
                                    <label>Fuel Type</label>
                                    <input type="text" name="fuel_type" class="form-control" value="{{ $item->fuel_type }}">
                                </div>

                                <div class="form-group">
                                    <label>Current Stock</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $item->stock }}" placeholder="how many does the store has left?">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" placeholder="Other information about the product">{{ $item->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <input id="images-container" type="text" name="images" style="display: none;">

                    </form>

                    <div class="row">
                        <!--<div class="col-lg-6">-->
                        <div class="col-lg-12">
                            <form id="dropzone" action="{{url("files/upload")}}" class="dropzone">
                            </form>
                        </div>
                        <!--                        <div class="col-lg-6">
                                                    <h4>Uploaded Images</h4>
                        
                                                    <img src="{{ $item->image_url  ? URL::to('/') . $item->image_url : "" }}" width="250px" height="250px" id="image-preview">
                                                    
                                                </div>-->
                    </div>

                </div><!-- ./box-body -->
                <div class="box-footer">
                    @include('module.parts.actions')
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection