<div class="form-repeater" id="bankRepeater">
  <div class="row g-2 align-items-end repeater-item">
    <div class="col-md-3">
      <label class="form-label">A/C Holder</label>
      <input type="text" name="banks[0][account_holder_name]" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">Bank</label>
      <input type="text" name="banks[0][bank_name]" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">Branch</label>
      <input type="text" name="banks[0][branch]" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">Account No</label>
      <input type="text" name="banks[0][account_no]" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">IFSC</label>
      <input type="text" name="banks[0][ifsc_code]" class="form-control">
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-outline-secondary btn-sm add-row" data-target="#bankRepeater">+ Add</button>
    </div>
  </div>
</div>
