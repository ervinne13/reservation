@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$client->username}}';
    var mode = '{{$mode}}';
</script>

<script type="text/html" id="password-fields-template">
    <div class="form-group">
        <label>Password</label>
        <input type="password" required name="password" class="form-control" >
    </div>

    <div class="form-group">
        <label>Repeat Password</label>
        <input type="password" required name="password_repeat" class="form-control">
    </div>
</script>

<script src="{{ asset ("/js/pages/clients/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Client
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
                                    <label>Username</label>
                                    <input type="text" required name="username" class="form-control" value="{{ $client->username }}">
                                </div>

                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" required name="full_name" class="form-control" value="{{ $client->full_name }}">
                                </div>

                                <div class="form-group">
                                    <label>Delinquent?</label>
                                    <select class="form-control" name="is_delinquent">
                                        <option value="0" selected disabled></option>
                                        <option value="1" {{$client->is_delinquent == 1 ? "selected" : ""}}>Yes</option>
                                        <option value="0" {{$client->is_delinquent == 0 ? "selected" : ""}}>No</option>
                                    </select>
                                </div>

                                <button id="action-reset-password" type="button" class="btn btn-link">Reset Password</button>

                                <div id="password-fields-container">
                                    <button id="action-show-passwords-field" type="button" class="btn btn-link">Change Password</button>
                                </div>

                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Contact Number 1</label>
                                    <input type="text" name="contact_number_1" class="form-control" value="{{ $client->contact_number_1 }}">
                                </div>

                                <div class="form-group">
                                    <label>Contact Number 2</label>
                                    <input type="text" name="contact_number_2" class="form-control" value="{{ $client->contact_number_2 }}">
                                </div>

                                <div class="form-group">
                                    <label>Landline Number</label>
                                    <input type="text" name="landline_number" class="form-control" value="{{ $client->landline_number }}">
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address">{{$client->address}}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if ($mode == "EDIT" || $mode == "VIEW")                   
                    <div class="row">
                        <div class="col-lg-12">                            
                            @include("pages.clients.payments-table")
                        </div>
                    </div>
                    @endif                    

                </div><!-- ./box-body -->
                <div class="box-footer">
                    @include('module.parts.actions')
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection