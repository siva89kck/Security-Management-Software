<div class="form-repeater" id="familyRepeater">
  <div class="row g-2 align-items-end repeater-item">
    <div class="col-md-3">
      <label class="form-label">Name</label>
      <input type="text" name="family_members[0][name]" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">DOB</label>
      <input type="date" name="family_members[0][dob]" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">Relationship</label>
      <input type="text" name="family_members[0][relationship]" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">Marital Status</label>
      <input type="text" name="family_members[0][marital_status]" class="form-control">
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-outline-secondary btn-sm add-row" data-target="#familyRepeater">+ Add</button>
    </div>
  </div>
</div>
