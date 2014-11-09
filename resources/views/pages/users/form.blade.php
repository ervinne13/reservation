@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$user->username}}';
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

<script src="{{ asset ("/js/pages/users/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User / Viewer
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
                                    <input type="text" required name="username" class="form-control" value="{{ $user->username }}">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="display_name" class="form-control" value="{{ $user->display_name }}">
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control required" required name="role_name">
                                        @foreach($roles AS $role)
                                        <option value="{{$role}}">{{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div id="password-fields-container">
                                    <button id="action-show-passwords-field" type="button" class="btn btn-link">Change Password</button>
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