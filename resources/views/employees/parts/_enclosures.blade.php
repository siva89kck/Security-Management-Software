<div class="enclosure-form-repeater mt-3" id="docRepeater">
    @php
        $oldEnclosures = old('enclosures');
        if (is_array($oldEnclosures) && count($oldEnclosures)) {
            $enclosures = $oldEnclosures;
        } elseif (isset($employee)) {
            $enclosures = $employee->enclosures->map(function($d) {
                return [
                    'document_type' => $d->document_type,
                    'original_copy' => $d->original_copy,
                    'proof_no'      => $d->proof_no,
                    'file_path'     => $d->file_path,
                ];
            })->toArray();
        } else {
            $enclosures = [['document_type'=>'','original_copy'=>'','proof_no'=>'','file_path'=>null]];
        }
    @endphp

    @foreach($enclosures as $i => $doc)
    <div class="row g-3 align-items-end repeater-item">
        <div class="col-md-6">
            <label class="form-label">Document</label>
            <select class="form-select" name="enclosures[{{ $i }}][document_type]">
                <option value="">--</option>
                @foreach(['PAN CARD','AADHAR CARD','VOTER ID','RATION CARD','Driving License','SCHOOL CERTIFICATE','DEGREE CERTIFICATE'] as $docType)
                <option value="{{ $docType }}" {{ ($doc['document_type'] ?? '') == $docType ? 'selected' : '' }}>{{ $docType }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Copy</label>
            <select class="form-select" name="enclosures[{{ $i }}][original_copy]">
                <option value="">--</option>
                @foreach(['Original','Xerox'] as $copyType)
                <option value="{{ $copyType }}" {{ ($doc['original_copy'] ?? '') == $copyType ? 'selected' : '' }}>{{ $copyType }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Proof No</label>
            <input type="text" name="enclosures[{{ $i }}][proof_no]" class="form-control" value="{{ $doc['proof_no'] ?? '' }}">
        </div>

        {{-- <div class="col-md-6">
            <label class="form-label">File</label>
            <input type="file" name="enclosures[{{ $i }}][file]" class="form-control">
            @if(!empty($doc['file_path']))
                <small class="text-success">
                    Existing file: <a href="{{ Storage::url($doc['file_path']) }}" target="_blank">View</a>
                </small>
            @endif
        </div> --}}

        <div class="col-md-6">
    <label class="form-label">File</label>
    <input type="file" name="enclosures[{{ $i }}][file]" class="form-control">

    {{-- 🔑 Preserve existing file path --}}
    @if(!empty($doc['file_path']))
        <input type="hidden" name="enclosures[{{ $i }}][file_path]" value="{{ $doc['file_path'] }}">
        <small class="text-success existing-file">
            Existing file: <a href="{{ Storage::url($doc['file_path']) }}" target="_blank">View</a>
        </small>
    @endif
</div>

        <div class="col-md-12 d-flex justify-content-end">
            @if($i == 0)
                <button type="button" class="btn btn-outline-primary btn-sm enclosure-add-row">
                    <i class="bi bi-plus-lg me-1"></i> Add Enclosure</button>
            @else
                <button type="button" class="btn btn-outline-danger btn-sm enclosure-remove-row">
                    <i class="bi bi-trash me-1"></i> Remove
            @endif
        </div>
    </div>
    @endforeach
</div>

<template id="enclosureTemplate">
    <div class="row g-3 align-items-end repeater-item">
        <div class="col-md-6">
            <label class="form-label">Document</label>
            <select class="form-select" name="enclosures[__INDEX__][document_type]">
                <option value="">--</option>
                <option value="PAN CARD">PAN CARD</option>
                <option value="AADHAR CARD">AADHAR CARD</option>
                <option value="VOTER ID">VOTER ID</option>
                <option value="RATION CARD">RATION CARD</option>
                <option value="Driving License">Driving License</option>
                <option value="SCHOOL CERTIFICATE">SCHOOL CERTIFICATE</option>
                <option value="DEGREE CERTIFICATE">DEGREE CERTIFICATE</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Copy</label>
            <select class="form-select" name="enclosures[__INDEX__][original_copy]">
                <option value="">--</option>
                <option value="Original">Original</option>
                <option value="Xerox">Xerox</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Proof No</label>
            <input type="text" name="enclosures[__INDEX__][proof_no]" class="form-control">
        </div>

        {{-- <div class="col-md-6">
            <label class="form-label">File</label>
            <input type="file" name="enclosures[__INDEX__][file]" class="form-control">
            <!-- 🔑 placeholder for existing file link -->
            <small class="text-success d-none existing-file">
                Existing file: <a href="#" target="_blank">View</a>
            </small>
        </div> --}}

        <div class="col-md-6">
    <label class="form-label">File</label>
    <input type="file" name="enclosures[__INDEX__][file]" class="form-control">
    <input type="hidden" name="enclosures[__INDEX__][file_path]" value="">
    <small class="text-success d-none existing-file">
        Existing file: <a href="#" target="_blank">View</a>
    </small>
</div>

        <div class="col-md-12 d-flex justify-content-end">
            <button type="button" class="btn btn-outline-danger btn-sm enclosure-remove-row">
                <i class="bi bi-trash me-1"></i> Remove
            </button>
        </div>
    </div>
</template>


<style>
.enclosure-form-repeater .repeater-item {
    background: #f9fafd;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    transition: all 0.2s;
}
.enclosure-form-repeater .repeater-item:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}
.enclosure-form-repeater .form-control,
.enclosure-form-repeater .form-select {
    border-radius: 8px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.enclosure-form-repeater .form-control:focus,
.enclosure-form-repeater .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}
.enclosure-form-repeater .btn {
    border-radius: 50px;
    padding: 4px 12px;
    margin-top: 5px;
}
.enclosure-form-repeater .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const repeater = document.querySelector("#docRepeater");
    let index = {{ count($enclosures) }};

    repeater.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("enclosure-add-row")) {
            const tpl = document.getElementById('enclosureTemplate').content.cloneNode(true);
            tpl.querySelectorAll('[name]').forEach(el => {
                el.setAttribute('name', el.getAttribute('name').replace(/__INDEX__/g, index));
            });
            repeater.appendChild(tpl);
            index++;
        }

        if (e.target && e.target.classList.contains("enclosure-remove-row")) {
            const item = e.target.closest('.repeater-item');
            if (item) item.remove();
        }
    });
});
</script>
