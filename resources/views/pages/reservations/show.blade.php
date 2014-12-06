@extends('layouts.lte')

@section('js')
<script type='text/javascript'>
    var id = '{{$reservation->id}}';
</script>
<script src="{{ asset ("/js/pages/reservations/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="fields-container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">

                                @if ( $reservation->reservedBy->is_delinquent)
                                <label class="text-danger">Delinquent Account!</label>                                
                                @else
                                <label class="text-success">Clean Account</label>
                                @endif

                                <div class="form-group">
                                    <label>Reserved By</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->reservedBy->full_name }}">
                                </div>

                                <div class="form-group">
                                    <label>Contact Number 1</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->reservedBy->contact_number_1 }}">
                                </div>

                                <div class="form-group">
                                    <label>Contact Number 2</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->reservedBy->contact_number_2 }}">
                                </div>

                                <div class="form-group">
                                    <label>Landline Number</label>
                                    <input type="text" disabled class="form-control" value="{{ $reservation->reservedBy->landline_number }}">
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea type="text" disabled class="form-control">{{ $reservation->reservedBy->address }}</textarea>
                                </div>                              

                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Item To Reserve</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->item->name }}">
                                </div>

                                <div class="form-group">
                                    <label>Total Cost</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->item->cost }}">
                                </div>

                                <div class="form-group">
                                    <label>Reservation Amount To Pay</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->reservation_amount }}">
                                </div>

                                <div class="form-group">
                                    <label>Proof of Payment</label>
                                    <img src="{{$reservation->attachment_image_url}}" style="width: 100%">
                                </div>

                                <div class="form-group">
                                    <label>Status</label>

                                    @if ($reservation->status == "With S.I.")
                                    <input type="text" disabled class="form-control " value="{{ $reservation->status }}">
                                    @else
                                    <select class="form-control" name="status">
                                        @foreach($statusList AS $status)
                                        <?php $selected = $status == $reservation->status ? "selected" : "" ?>
                                        <option value="{{$status}}" {{$selected}}>
                                            {{$status}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <div class="row">
                        @if ($reservation->status != "With S.I.")
                        <div class="col-lg-12">
                            <div class="box-foot pull-right">
                                <button id="action-update-status" type="button" class="btn btn-primary action-button">Update Status</button>                                
                                <button id="action-convert-si" type="button" class="btn btn-success action-button">Create Invoice</button>                                
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection