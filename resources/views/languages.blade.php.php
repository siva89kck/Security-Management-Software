<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Languages Known</h5>
        <button type="button" class="btn btn-sm btn-primary" id="addLanguage">Add More</button>
    </div>
    <div class="card-body" id="languagesContainer">
        <div class="language-row mb-3 border-bottom pb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Language</label>
                        <input type="text" class="form-control" name="languages[0][language]">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Proficiency</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[0][read]" value="1">
                            <label class="form-check-label">Read</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[0][write]" value="1">
                            <label class="form-check-label">Write</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[0][speak]" value="1">
                            <label class="form-check-label">Speak</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger remove-language" style="display: none;">Remove</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let languageCount = 1;

    // Add more languages
    $('#addLanguage').click(function() {
        const newRow = `
        <div class="language-row mb-3 border-bottom pb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Language</label>
                        <input type="text" class="form-control" name="languages[${languageCount}][language]">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Proficiency</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[${languageCount}][read]" value="1">
                            <label class="form-check-label">Read</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[${languageCount}][write]" value="1">
                            <label class="form-check-label">Write</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[${languageCount}][speak]" value="1">
                            <label class="form-check-label">Speak</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger remove-language">Remove</button>
        </div>
        `;

        $('#languagesContainer').append(newRow);
        languageCount++;
    });

    // Remove language row
    $(document).on('click', '.remove-language', function() {
        $(this).closest('.language-row').remove();
    });
});
</script>
