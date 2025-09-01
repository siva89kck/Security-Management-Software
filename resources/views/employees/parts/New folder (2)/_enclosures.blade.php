<div class="form-repeater" id="docRepeater">
  <div class="row g-2 align-items-end repeater-item">
    <div class="col-md-3">
      <label class="form-label">Document</label>
      <select class="form-select" name="enclosures[0][document_type]">
        <option value="">--</option>
        <option>PAN CARD</option>
        <option>AADHAR CARD</option>
        <option>VOTER ID</option>
        <option>RATION CARD</option>
        <option>Driving License</option>
        <option>SCHOOL CERTIFICATE</option>
        <option>DEGREE CERTIFICATE</option>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">Copy</label>
      <select class="form-select" name="enclosures[0][original_copy]">
        <option value="">--</option>
        <option>Original</option>
        <option>Xerox</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Proof No</label>
      <input type="text" name="enclosures[0][proof_no]" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">File</label>
      <input type="file" name="enclosures[0][file]" class="form-control">
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-outline-secondary btn-sm add-row" data-target="#docRepeater">+ Add</button>
    </div>
  </div>
</div>
