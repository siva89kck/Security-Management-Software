<div class="bank-form-repeater mt-3" id="bankRepeater">
    @php
        $banks = old('banks');

        if (empty($banks) && isset($employee) && $employee->bankDetails->count() > 0) {
            $banks = $employee->bankDetails->map(function($bank) {
                return [
                    'account_holder_name' => $bank->account_holder_name,
                    'bank_name'           => $bank->bank_name,
                    'branch'              => $bank->branch,
                    'account_no'          => $bank->account_no,
                    'ifsc_code'           => $bank->ifsc_code,
                ];
            })->toArray();
        }

        if (empty($banks)) {
            $banks = [[
                'account_holder_name'=>'',
                'bank_name'=>'',
                'branch'=>'',
                'account_no'=>'',
                'ifsc_code'=>''
            ]];
        }
    @endphp

    @foreach($banks as $i => $bank)
    <div class="row g-3 align-items-end repeater-item">
        <div class="col-md-6">
            <label class="form-label">A/C Holder</label>
            <input type="text" name="banks[{{ $i }}][account_holder_name]" class="form-control" value="{{ $bank['account_holder_name'] ?? '' }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Bank</label>
            <input type="text" name="banks[{{ $i }}][bank_name]" class="form-control" value="{{ $bank['bank_name'] ?? '' }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Branch</label>
            <input type="text" name="banks[{{ $i }}][branch]" class="form-control" value="{{ $bank['branch'] ?? '' }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Account No</label>
            <input type="text" name="banks[{{ $i }}][account_no]" class="form-control" value="{{ $bank['account_no'] ?? '' }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">IFSC</label>
            <input type="text" name="banks[{{ $i }}][ifsc_code]" class="form-control" value="{{ $bank['ifsc_code'] ?? '' }}">
        </div>

        <div class="col-md-6 d-flex align-items-end">
            @if($i == 0)
                <button type="button" class="btn btn-outline-primary btn-sm bank-add-row">
                    <i class="bi bi-plus-lg me-1"></i> Add Bank</button>
            @else
                <button type="button" class="btn btn-outline-danger btn-sm bank-remove-row">
                    <i class="bi bi-trash me-1"></i> Remove
                </button>
            @endif
        </div>
    </div>
    @endforeach
</div>

<style>
.bank-form-repeater .repeater-item {
    background: #f9fafd;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.bank-form-repeater .btn { border-radius: 50px; padding: 4px 12px; }
</style>

<script>
document.addEventListener('click', function(e) {
    const repeater = document.querySelector('#bankRepeater');

    // Add new bank row
    if (e.target.classList.contains('bank-add-row')) {
        const row = e.target.closest('.repeater-item');
        const clone = row.cloneNode(true);

        // Clear inputs
        clone.querySelectorAll('input').forEach(input => input.value = '');

        // Update Add button to Remove button
        const btn = clone.querySelector('.bank-add-row');
        btn.classList.remove('bank-add-row', 'btn-outline-primary');
        btn.classList.add('bank-remove-row', 'btn-outline-danger');
        btn.textContent = 'Remove';

        repeater.appendChild(clone);

        // 🔑 Re-index all rows
        updateBankIndexes();
    }

    // Remove row
    if (e.target.classList.contains('bank-remove-row')) {
        e.target.closest('.repeater-item').remove();
        updateBankIndexes();
    }

    function updateBankIndexes() {
        repeater.querySelectorAll('.repeater-item').forEach((row, index) => {
            row.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/banks\[\d+\]/, `banks[${index}]`));
                }
            });
        });
    }
});
</script>
