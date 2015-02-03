<script type="text/html" id="si-details-form-template">
    <form id="sales-invoice-detail-form" class="row" role="form" class="container">

        <input type="text" readonly name="line_number" class="form-control" style="display: none;">        
        <input type="text" readonly name="document_number" class="form-control" style="display: none;">        

        <div class="col-md-6">
            <div class="form-group">
                <label>Item ID:</label>
                <select class="form-control required" name="item_id" placeholder="Item" required> 
                    <option value="" disabled selected></option>
                    @foreach ($items AS $item)
                    <option value="{{$item->id}}" 
                            data-name="{{$item->name}}" 
                            data-model="{{$item->model}}" 
                            data-cost="{{$item->cost}}">
                        {{$item->name}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Item Name:</label>
                <input type="text" required readonly name="item_name" class="form-control required" placeholder="Name of the item">
            </div>
            <div class="form-group">
                <label>Item Model:</label>
                <input type="text" required readonly name="item_model" class="form-control required" placeholder="Model name of the item">
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Qty</label>
                <input type="number" required name="item_qty" class="form-control required" placeholder="How many units will the customer order?">
            </div>
            <div class="form-group">
                <label>Item Cost</label>
                <input type="text" required readonly name="item_cost" class="form-control required" placeholder="00,000.00">
            </div>
            <div class="form-group">
                <label>Sub Total</label>
                <input type="text" required readonly name="sub_total" class="form-control required" placeholder="00,000.00">
            </div>
        </div>
    </form>
</script>
