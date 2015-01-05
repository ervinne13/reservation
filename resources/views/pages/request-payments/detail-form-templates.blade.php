<script type="text/html" id="rp-details-form-template">
    <form id="request-payment-detail-form" class="row" role="form" class="container">

        <input type="text" readonly name="line_number" class="form-control" style="display: none;">        
        <input type="text" readonly name="document_number" class="form-control" style="display: none;">        

        <div class="col-md-6">
            <div class="form-group">
                <label>Payment To (Type):</label>
                <select name="payment_type_code" class="form-control">
                    @foreach($paymentTypes AS $paymentType)                    
                    <option value="{{$paymentType->code}}">
                        {{$paymentType->description}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Payment Amount:</label>
                <input type="text" required name="amount" class="form-control required" placeholder="xx,xxx.xx">
            </div>           

        </div>
        <div class="col-md-6">      
            <div class="form-group">
                <label>Comment / Remarks</label>
                <textarea class="form-control" name="comment" placeholder="Fill in for any remarks for this payment"></textarea>
            </div>
        </div>
    </form>
</script>
