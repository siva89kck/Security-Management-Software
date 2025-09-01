<h6 class="mt-3 mb-2">Payroll Details</h6>

<div class="payslip-form mt-3">
    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Basic %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[basic]"
                   value="{{ old('payslip.basic', $payslip->basic ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Allowance1 %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[allowance1]"
                   value="{{ old('payslip.allowance1', $payslip->allowance1 ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">HRA %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[hra]"
                   value="{{ old('payslip.hra', $payslip->hra ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Allowance2 %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[allowance2]"
                   value="{{ old('payslip.allowance2', $payslip->allowance2 ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">DA %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[da]"
                   value="{{ old('payslip.da', $payslip->da ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Gratuity %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[gratuity]"
                   value="{{ old('payslip.gratuity', $payslip->gratuity ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Travel Allowance %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[travel_allowance]"
                   value="{{ old('payslip.travel_allowance', $payslip->travel_allowance ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Bonus %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[bonus]"
                   value="{{ old('payslip.bonus', $payslip->bonus ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Leave Allowance %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[leave_allowance]"
                   value="{{ old('payslip.leave_allowance', $payslip->leave_allowance ?? '0.00') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Other Allowance %</label>
            <input type="number" step="0.01" class="form-control" name="payslip[other_allowance]"
                   value="{{ old('payslip.other_allowance', $payslip->other_allowance ?? '0.00') }}">
        </div>

    </div>
</div>

<style>
/* Payslip form card like family/experience */
.payslip-form {
    background: #f9fafd;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-top: 15px;
}

.payslip-form:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

.payslip-form .form-control {
    border-radius: 10px;
    border: 1px solid #ced4da;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.payslip-form .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}
</style>
