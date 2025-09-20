@php
$indianStates = [
    'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat',
    'Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra',
    'Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu',
    'Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands',
    'Chandigarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir','Ladakh',
    'Lakshadweep','Puducherry'
];

$perm = $addresses['permanent'] ?? [];
$pres = $addresses['present'] ?? [];

/** check permanent address filled or not */
$permFilled = !empty($perm['address_line1']) && !empty($perm['city']) && !empty($perm['state']) && !empty($perm['pincode']);

/** check both addresses same */
$isSame = $permFilled && (
    ($pres['address_line1'] ?? '') === ($perm['address_line1'] ?? '') &&
    ($pres['address_line2'] ?? '') === ($perm['address_line2'] ?? '') &&
    ($pres['city'] ?? '') === ($perm['city'] ?? '') &&
    ($pres['state'] ?? '') === ($perm['state'] ?? '') &&
    ($pres['pincode'] ?? '') === ($perm['pincode'] ?? '')
);
@endphp

<style>
.address-card {
    background: #f9fafd;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}
.address-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
.address-card .form-control {
    border-radius: 8px;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.address-card .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}
.address-card h6 { margin-bottom: 15px; }
</style>

<!-- Permanent Address -->
<div class="address-card">
    <h6>Permanent Address</h6>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Address Line 1 *</label>
            <input type="text" name="addresses[permanent][address_line1]" class="form-control" id="perm_line1"
                value="{{ old('addresses.permanent.address_line1', $perm['address_line1'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Address Line 2</label>
            <input type="text" name="addresses[permanent][address_line2]" class="form-control" id="perm_line2"
                value="{{ old('addresses.permanent.address_line2', $perm['address_line2'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">City *</label>
            <input type="text" name="addresses[permanent][city]" class="form-control" id="perm_city"
                value="{{ old('addresses.permanent.city', $perm['city'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">State *</label>
            <select name="addresses[permanent][state]" class="form-control" id="perm_state">
                <option value="">Select State</option>
                @foreach($indianStates as $state)
                    <option value="{{ $state }}" {{ old('addresses.permanent.state',$perm['state']??'')==$state?'selected':'' }}>{{ $state }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Pincode *</label>
            <input type="text" name="addresses[permanent][pincode]" class="form-control" id="perm_pincode"
                value="{{ old('addresses.permanent.pincode', $perm['pincode'] ?? '') }}">
        </div>
    </div>
</div>

<!-- Same as Permanent Checkbox -->
<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="sameAsPermanent" {{ $isSame ? 'checked' : '' }}>
    <label class="form-check-label" for="sameAsPermanent">Present address same as Permanent</label>
</div>

<!-- Present Address -->
<div class="address-card">
    <h6>Present Address</h6>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Address Line 1 *</label>
            <input type="text" name="addresses[present][address_line1]" class="form-control" id="pres_line1"
                value="{{ old('addresses.present.address_line1', $pres['address_line1'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Address Line 2</label>
            <input type="text" name="addresses[present][address_line2]" class="form-control" id="pres_line2"
                value="{{ old('addresses.present.address_line2', $pres['address_line2'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">City *</label>
            <input type="text" name="addresses[present][city]" class="form-control" id="pres_city"
                value="{{ old('addresses.present.city', $pres['city'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">State *</label>
            <select name="addresses[present][state]" class="form-control" id="pres_state">
                <option value="">Select State</option>
                @foreach($indianStates as $state)
                    <option value="{{ $state }}" {{ old('addresses.present.state',$pres['state']??'')==$state?'selected':'' }}>{{ $state }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Pincode *</label>
            <input type="text" name="addresses[present][pincode]" class="form-control" id="pres_pincode"
                value="{{ old('addresses.present.pincode', $pres['pincode'] ?? '') }}">
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sameCheckbox = document.getElementById('sameAsPermanent');
    sameCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        const perm_line1 = document.getElementById('perm_line1').value;
        const perm_line2 = document.getElementById('perm_line2').value;
        const perm_city = document.getElementById('perm_city').value;
        const perm_state = document.getElementById('perm_state').value;
        const perm_pincode = document.getElementById('perm_pincode').value;

        if (isChecked) {
            // permanent address check
            if (!perm_line1 || !perm_city || !perm_state || !perm_pincode) {
                alert('Please fill Permanent Address before selecting this option.');
                this.checked = false;
                return;
            }
            document.getElementById('pres_line1').value = perm_line1;
            document.getElementById('pres_line2').value = perm_line2;
            document.getElementById('pres_city').value = perm_city;
            document.getElementById('pres_state').value = perm_state;
            document.getElementById('pres_pincode').value = perm_pincode;
        } else {
            document.getElementById('pres_line1').value = '';
            document.getElementById('pres_line2').value = '';
            document.getElementById('pres_city').value = '';
            document.getElementById('pres_state').value = '';
            document.getElementById('pres_pincode').value = '';
        }
    });
});
</script>
