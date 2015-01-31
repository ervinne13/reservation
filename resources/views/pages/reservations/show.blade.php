@extends('layouts.lte')

@section('js')
<script type='text/javascript'>
    var id = '{{$reservation->id}}';
    var reservation = JSON.parse('{!! $reservation !!}');
    var item = JSON.parse('{!! $reservation->item !!}');
</script>

<script src="{{ asset ("/vendor/momentjs/moment.js") }}" type="text/javascript"></script>

<script src="{{ asset ("/js/sms-utility.js") }}" type="text/javascript"></script>
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
                                    <input type="text" name="contact_number_1" readonly class="form-control " value="{{ $reservation->reservedBy->contact_number_1 }}">
                                </div>

                                <div class="form-group">
                                    <label>Contact Number 2</label>
                                    <input type="text" name="contact_number_2" readonly class="form-control " value="{{ $reservation->reservedBy->contact_number_2 }}">
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
                                    <input type="text" name="item_name" readonly class="form-control " value="{{ $reservation->item->name }}">
                                </div>

                                <div class="form-group">
                                    <label>Total Cost (Per Unit)</label>
                                    <input type="text" disabled class="form-control " value="{{ number_format($reservation->item->cost, 2) }}">
                                </div>

                                <div class="form-group">
                                    <label>Reservation Amount To Pay (Per Unit)</label>
                                    <input type="text" disabled class="form-control " value="{{ number_format($reservation->reservation_amount, 2) }}">
                                </div>

                                <div class="form-group">
                                    <label>Qty to Reserve</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->qty_to_reserve }}">
                                </div>

                                <div class="form-group">
                                    <label>Total Reservation Amount</label>
                                    <input type="text" disabled class="form-control " value="{{ number_format($reservation->reservation_amount * $reservation->qty_to_reserve, 2) }}">
                                </div>

                                <div class="form-group">
                                    <label>Terms (Months to Pay)</label>
                                    <input type="text" disabled class="form-control " value="{{ $reservation->terms }}">
                                </div>

                                <div class="form-group">
                                    <label>Payment Preference</label>
                                    <input type="text" disabled name="preferred_payment" class="form-control required" value="{{ $reservation->preferred_payment }}">
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