@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$item->id}}';
    var mode = '{{$mode}}';
</script>

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
                                    <input type="text" required name="model" class="form-control required" value="{{ $item->model }}">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control required" value="{{ $item->name }}">
                                </div>

                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="number" required name="cost" class="form-control required" value="{{ $item->cost }}">
                                </div>

                                <div class="form-group">
                                    <label>Reservation Cost</label>
                                    <input type="number" required name="reservation_cost" class="form-control required" value="{{ $item->reservation_cost }}">
                                </div>

                                <div class="form-group">
                                    <label>Current Stock</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $item->stock }}">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                                </div>

                            </div>
                            <div class="col-lg-6 col-sm-12">

                                <div class="form-group">
                                    <label>Engine Type</label>
                                    <input type="text" required name="engine_type" class="form-control" value="{{ $item->engine_type }}">
                                </div>

                                <div class="form-group">
                                    <label>Engine Stroke</label>
                                    <input type="text" required name="engine_stroke" class="form-control" value="{{ $item->engine_stroke }}">
                                </div>

                                <div class="form-group">
                                    <label>Oil Capacity</label>
                                    <input type="text" required name="oil_capacity" class="form-control" value="{{ $item->oil_capacity }}">
                                </div>

                                <div class="form-group">
                                    <label>Fuel Type</label>
                                    <input type="text" required name="fuel_type" class="form-control" value="{{ $item->fuel_type }}">
                                </div>                                
                            </div>

                            <div class="col-lg-12">
                                <hr>
                                <legend>Upload up to 4 images</legend>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    @if ($mode == "VIEW")                                    
                                    <img src="{{ $item->image_url  ? URL::to('/') . $item->image_url : "" }}" width="250px" height="250px" id="image-preview">        
                                    @else
                                    <div id="image-preview-container" class="form-group">
                                        <label for="input-student-image">Item Image</label>
                                        <input type="file" id="input-item-image" name="image">
                                        <p class="help-block">Ideal size is 250px x 250px</p>

                                        <img src="{{ $item->image_url  ? URL::to('/') . $item->image_url : "" }}" width="250px" height="250px" id="image-preview">
                                        <input type="hidden" name="image_url">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    @if ($mode == "VIEW")
                                    <label for="input-student-image">Image 1</label>
                                    <img src="{{ $item->image_url  ? URL::to('/') . $item->image_url : "" }}" width="250px" height="250px" id="image-preview">        
                                    @else
                                    <div id="image-preview-container" class="form-group">
                                        <label for="input-student-image">Item Image</label>
                                        <input type="file" id="input-item-image" name="image">
                                        <p class="help-block">Ideal size is 250px x 250px</p>

                                        <img src="{{ $item->image_url  ? URL::to('/') . $item->image_url : "" }}" width="250px" height="250px" id="image-preview">
                                        <input type="hidden" name="image_url">
                                    </div>
                                    @endif
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