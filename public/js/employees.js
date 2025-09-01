(function($){
  // CSRF for AJAX
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  // Copy permanent -> present
  $('#sameAsPermanent').on('change', function(){
    const checked = $(this).is(':checked');
    const map = [
      ['#perm_line1','#pres_line1'],
      ['#perm_line2','#pres_line2'],
      ['#perm_city','#pres_city'],
      ['#perm_state','#pres_state'],
      ['#perm_pincode','#pres_pincode'],
    ];
    map.forEach(([from,to]) => {
      $(to).val($(from).val());
      $(to).prop('readonly', checked);
    });
  });

  // Generic repeater add
  $(document).on('click', '.add-row', function(){
    const target = $($(this).data('target'));
    const items = target.find('.repeater-item');
    const last = items.last();
    const clone = last.clone();
    // clear values and increment indexes
    const idx = items.length;
    clone.find('input,select').each(function(){
      const name = $(this).attr('name') || '';
      const newName = name.replace(/\[\d+\]/, '['+idx+']');
      $(this).attr('name', newName);
      if ($(this).is(':checkbox')) {
        this.checked = false;
      } else {
        $(this).val('');
      }
    });
    target.append(clone);
  });

  // AJAX submit with files
  $('#employeeForm').on('submit', function(e){
    e.preventDefault();
    const $btn = $('#btnSave').prop('disabled', true);
    const $alert = $('#formAlert').removeClass('d-none alert-success alert-danger').empty();

    const form = this;
    const data = new FormData(form);

    $.ajax({
      url: $(form).attr('action'),
      method: 'POST',
      data: data,
      processData: false,
      contentType: false,
      success: function(res){
        $alert.addClass('alert alert-success').text('Saved successfully! Redirecting...');
        setTimeout(function(){ window.location = '/employees'; }, 700);
      },
      error: function(xhr){
        let msg = 'Validation error';
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          msg = Object.values(xhr.responseJSON.errors).map(a=>a.join(', ')).join(' | ');
        }
        $alert.addClass('alert alert-danger').text(msg);
      },
      complete: function(){ $btn.prop('disabled', false); }
    });
  });
})(jQuery);
