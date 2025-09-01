<div class="form-repeater" id="languagesRepeater">
  <div class="row g-2 align-items-end repeater-item">
    <div class="col-md-4">
      <label class="form-label">Language</label>
      <input type="text" name="languages[0][language]" class="form-control">
    </div>
    <div class="col-md-6 d-flex align-items-center gap-3 mt-3 mt-md-0">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="languages[0][read]" value="1" id="lang0read">
        <label class="form-check-label" for="lang0read">Read</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="languages[0][write]" value="1" id="lang0write">
        <label class="form-check-label" for="lang0write">Write</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="languages[0][speak]" value="1" id="lang0speak">
        <label class="form-check-label" for="lang0speak">Speak</label>
      </div>
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-outline-secondary btn-sm add-row" data-target="#languagesRepeater">+ Add</button>
    </div>
  </div>
</div>
