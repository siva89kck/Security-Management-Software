<div class="card">
    <div class="card-header">
        <h5>Address Information</h5>
    </div>
    <div class="card-body">
        <!-- Permanent Address -->
        <div class="form-group">
            <label>Permanent Address</label>
            <input type="text" class="form-control" name="addresses[0][address_line1]" placeholder="Address Line 1">
            <input type="text" class="form-control mt-2" name="addresses[0][address_line2]" placeholder="Address Line 2">

            <div class="row mt-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="addresses[0][city]" placeholder="City">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="addresses[0][state]" placeholder="State">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="addresses[0][pincode]" placeholder="Pincode">
                </div>
            </div>
            <input type="hidden" name="addresses[0][type]" value="permanent">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="sameAsPermanent">
            <label class="form-check-label" for="sameAsPermanent">Same as Permanent Address</label>
        </div>

        <!-- Present Address -->
        <div class="form-group">
            <label>Present Address</label>
            <input type="text" class="form-control" id="present_address_line1" name="addresses[1][address_line1]" placeholder="Address Line 1">
            <input type="text" class="form-control mt-2" id="present_address_line2" name="addresses[1][address_line2]" placeholder="Address Line 2">

            <div class="row mt-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="present_city" name="addresses[1][city]" placeholder="City">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="present_state" name="addresses[1][state]" placeholder="State">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="present_pincode" name="addresses[1][pincode]" placeholder="Pincode">
                </div>
            </div>
            <input type="hidden" name="addresses[1][type]" value="present">
        </div>
    </div>
</div>
