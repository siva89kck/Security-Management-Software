<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Bank Account Details</h5>
        <button type="button" class="btn btn-sm btn-primary" id="addBank">Add More</button>
    </div>
    <div class="card-body" id="bankContainer">
        <div class="bank-row mb-3 border-bottom pb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Account Holder Name</label>
                        <input type="text" class="form-control" name="bank_details[0][account_holder_name]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" class="form-control" name="bank_details[0][bank_name]">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Branch</label>
                        <input type="text" class="form-control" name="bank_details[0][branch]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" class="form-control" name="bank_details[0][account_no]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" class="form-control" name="bank_details[0][card_no]">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>IFSC Code</label>
                        <input type="text" class="form-control" name="bank_details[0][ifsc_code]">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-danger remove-bank" style="display: none;">Remove</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let bankCount = 1;

    // Add more bank accounts
    $('#addBank').click(function() {
        const newRow = `
        <div class="bank-row mb-3 border-bottom pb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Account Holder Name</label>
                        <input type="text" class="form-control" name="bank_details[${bankCount}][account_holder_name]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" class="form-control" name="bank_details[${bankCount}][bank_name]">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Branch</label>
                        <input type="text" class="form-control" name="bank_details[${bankCount}][branch]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" class="form-control" name="bank_details[${bankCount}][account_no]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" class="form-control" name="bank_details[${bankCount}][card_no]">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>IFSC Code</label>
                        <input type="text" class="form-control" name="bank_details[${bankCount}][ifsc_code]">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-danger remove-bank">Remove</button>
        </div>
        `;

        $('#bankContainer').append(newRow);
        bankCount++;
    });

    // Remove bank row
    $(document).on('click', '.remove-bank', function() {
        $(this).closest('.bank-row').remove();
    });
});
</script>
