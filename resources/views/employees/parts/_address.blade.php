<style>
    .address-card {
        background: #f9fafd;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .address-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .address-card .form-control {
        border-radius: 8px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .address-card .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }

    .address-card h6 {
        margin-bottom: 15px;
    }
</style>

<div class="address-card">
    <h6>Permanent Address</h6>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Address Line 1 *</label>
            <input type="text" name="addresses[permanent][address_line1]" class="form-control" id="perm_line1"
                value="{{ old('addresses.permanent.address_line1', $addresses['permanent']['address_line1'] ?? '') }}"
                >
            <div class="invalid-feedback">Please enter Address Line 1.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Address Line 2</label>
            <input type="text" name="addresses[permanent][address_line2]" class="form-control" id="perm_line2"
                value="{{ old('addresses.permanent.address_line2', $addresses['permanent']['address_line2'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">City *</label>
            <input type="text" name="addresses[permanent][city]" class="form-control" id="perm_city"
                value="{{ old('addresses.permanent.city', $addresses['permanent']['city'] ?? '') }}" >
            <div class="invalid-feedback">Please enter city.</div>
        </div>
        <div class="col-md-4">
            <label class="form-label">State *</label>
            <input type="text" name="addresses[permanent][state]" class="form-control" id="perm_state"
                value="{{ old('addresses.permanent.state', $addresses['permanent']['state'] ?? '') }}" >
            <div class="invalid-feedback">Please enter state.</div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Pincode *</label>
            <input type="text" name="addresses[permanent][pincode]" class="form-control" id="perm_pincode"
                value="{{ old('addresses.permanent.pincode', $addresses['permanent']['pincode'] ?? '') }}" >
            <div class="invalid-feedback">Please enter pincode.</div>
        </div>
    </div>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="sameAsPermanent">
    <label class="form-check-label" for="sameAsPermanent">Present address same as Permanent</label>
</div>

<div class="address-card">
    <h6>Present Address</h6>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Address Line 1 *</label>
            <input type="text" name="addresses[present][address_line1]" class="form-control" id="pres_line1"
                value="{{ old('addresses.present.address_line1', $addresses['present']['address_line1'] ?? '') }}"
                >
            <div class="invalid-feedback">Please enter Address Line 1.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Address Line 2</label>
            <input type="text" name="addresses[present][address_line2]" class="form-control" id="pres_line2"
                value="{{ old('addresses.present.address_line2', $addresses['present']['address_line2'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">City *</label>
            <input type="text" name="addresses[present][city]" class="form-control" id="pres_city"
                value="{{ old('addresses.present.city', $addresses['present']['city'] ?? '') }}" >
            <div class="invalid-feedback">Please enter city.</div>
        </div>
        <div class="col-md-4">
            <label class="form-label">State *</label>
            <input type="text" name="addresses[present][state]" class="form-control" id="pres_state"
                value="{{ old('addresses.present.state', $addresses['present']['state'] ?? '') }}" >
            <div class="invalid-feedback">Please enter state.</div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Pincode *</label>
            <input type="text" name="addresses[present][pincode]" class="form-control" id="pres_pincode"
                value="{{ old('addresses.present.pincode', $addresses['present']['pincode'] ?? '') }}" >
            <div class="invalid-feedback">Please enter pincode.</div>
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

        // Bootstrap validation
        // const forms = document.querySelectorAll('.app-form');
        // Array.from(forms).forEach(function(form) {
        //     form.addEventListener('submit', function(event) {
        //         if (!form.checkValidity()) {
        //             event.preventDefault();
        //             event.stopPropagation();
        //         }
        //         form.classList.add('was-validated');
        //     }, false);
        // });
    });
</script>
