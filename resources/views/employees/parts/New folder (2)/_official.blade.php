<div class="row g-3">
  <div class="col-md-3">
    <label class="form-label">Role</label>
    <select name="official[role]" class="form-select">
      <option value="">--</option>
      <option>Security Guard</option>
      <option>Admin</option>
      <option>Supervisor</option>
      <option>Field Officer</option>
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Date of Join</label>
    <input type="date" name="official[date_of_join]" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Employee Type</label>
    <select name="official[employee_type]" class="form-select">
      <option value="">--</option>
      <option>Permanent</option>
      <option>Temporary</option>
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Salary</label>
    <input type="number" name="official[salary]" class="form-control" step="0.01" min="0">
  </div>
  <div class="col-md-3">
    <label class="form-label">PF Number</label>
    <input type="text" name="official[pf_number]" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">ESI Number</label>
    <input type="text" name="official[esi_number]" class="form-control">
  </div>
  <div class="col-md-3 form-check mt-4 ms-2">
    <input class="form-check-input" type="checkbox" name="official[pf_calculation]" value="1" id="pf_calc">
    <label class="form-check-label" for="pf_calc">PF Calculation</label>
  </div>
  <div class="col-md-3 form-check mt-4 ms-2">
    <input class="form-check-input" type="checkbox" name="official[esi_calculation]" value="1" id="esi_calc">
    <label class="form-check-label" for="esi_calc">ESI Calculation</label>
  </div>
</div>
