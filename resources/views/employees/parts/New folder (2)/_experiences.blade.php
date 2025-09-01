<div class="form-repeater" id="expRepeater">
  <div class="row g-2 align-items-end repeater-item">
    <div class="col-md-4">
      <label class="form-label">Company</label>
      <input type="text" name="experiences[0][company_name]" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">Designation</label>
      <input type="text" name="experiences[0][designation]" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">Experience</label>
      <input type="text" name="experiences[0][experience]" class="form-control" placeholder="e.g., 2 Years">
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-outline-secondary btn-sm add-row" data-target="#expRepeater">+ Add</button>
    </div>
  </div>
</div>
