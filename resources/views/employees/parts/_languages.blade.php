<style>
/* Language card */
.language-repeater .language-card {
    background: #f9fafd;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.language-repeater .language-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

/* Form inputs & selects */
.language-repeater .form-control,
.language-repeater .form-select {
    border-radius: 8px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.language-repeater .form-control:focus,
.language-repeater .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}

/* Buttons */
.language-repeater .btn-sm {
    min-width: 100px;
    border-radius: 50px;
    transition: all 0.2s ease;
}

.language-repeater .btn-outline-primary:hover {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.language-repeater .btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
    border-color: #dc3545;
}

/* Checkbox spacing */
.language-repeater .form-check-inline {
    margin-right: 10px;
    margin-bottom: 5px;
}
</style>
<h6 class="mt-3 mb-2">Languages</h6>

<div id="languagesRepeater" class="language-repeater">

    @php
        $savedLangs = old('languages', $employee->languages ?? []);
        $defaultLangs = [
            ['language' => 'Tamil',  'read' => 0, 'write' => 0, 'speak' => 0],
            ['language' => 'Hindi',  'read' => 0, 'write' => 0, 'speak' => 0],
            ['language' => 'English','read' => 0, 'write' => 0, 'speak' => 0],
        ];
        $extraLangs = [];
        foreach ($savedLangs as $lang) {
            if (!in_array($lang['language'], array_column($defaultLangs, 'language'))) {
                $extraLangs[] = $lang;
            } else {
                foreach ($defaultLangs as &$d) {
                    if ($d['language'] == $lang['language']) {
                        $d['read']  = $lang['read'] ?? 0;
                        $d['write'] = $lang['write'] ?? 0;
                        $d['speak'] = $lang['speak'] ?? 0;
                    }
                }
            }
        }
    @endphp

    {{-- Default Languages --}}
    @foreach($defaultLangs as $i => $lang)
    <div class="card language-card">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="col-md-3 mb-2 mb-md-0">
                {{-- <label class="form-label">Language</label> --}}
                <input type="text" class="form-control" name="languages[{{ $i }}][language]" value="{{ $lang['language'] }}" readonly required>
                <div class="invalid-feedback">Language required</div>
            </div>
            <div class="col-md-8 d-flex gap-3 flex-wrap">
                @foreach(['read'=>'Read', 'write'=>'Write', 'speak'=>'Speak'] as $key=>$label)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="languages[{{ $i }}][{{ $key }}]" value="1" {{ $lang[$key] ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    {{-- Extra Languages --}}
    @foreach($extraLangs as $i => $lang)
        @php $index = $i + count($defaultLangs); @endphp
        <div class="card language-card">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="form-label">Language *</label>
                    <input type="text" class="form-control" name="languages[{{ $index }}][language]" value="{{ $lang['language'] }}" required>
                    <div class="invalid-feedback">Language required</div>
                </div>
                <div class="col-md-7 d-flex gap-3 flex-wrap">
                    @foreach(['read'=>'Read', 'write'=>'Write', 'speak'=>'Speak'] as $key=>$label)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="languages[{{ $index }}][{{ $key }}]" value="1" {{ $lang[$key] ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                        <i class="bi bi-trash me-1"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Add Button --}}
    <div class="mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center add-language-btn" data-target="#languagesRepeater">
            <i class="bi bi-plus-lg me-1"></i> Add Language
        </button>
    </div>
</div>

{{-- Template --}}
<template id="languageTemplate">
    <div class="card language-card">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="form-label">Language *</label>
                <input type="text" class="form-control" name="languages[new][language]" required>
                <div class="invalid-feedback">Language required</div>
            </div>
            <div class="col-md-7 d-flex gap-3 flex-wrap">
                @foreach(['read'=>'Read', 'write'=>'Write', 'speak'=>'Speak'] as $key=>$label)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="languages[new][{{ $key }}]" value="1">
                        <label class="form-check-label">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
            <div class="col-md-2 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-row d-flex align-items-center">
                    <i class="bi bi-trash me-1"></i> Remove
                </button>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("add-language-btn")) {
        const container = document.querySelector(e.target.dataset.target);
        const template = document.querySelector("#languageTemplate");
        const newRow = template.content.cloneNode(true);
        container.appendChild(newRow);
    }
    if (e.target.classList.contains("remove-row")) {
        e.target.closest(".language-card").remove();
    }
});

// Bootstrap form validation
// const forms = document.querySelectorAll('.app-form');
// Array.from(forms).forEach(form => {
//     form.addEventListener('submit', function(event) {
//         if (!form.checkValidity()) {
//             event.preventDefault();
//             event.stopPropagation();
//         }
//         form.classList.add('was-validated');
//     });
// });
</script>
