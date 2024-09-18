<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(document).on('click', '.edit', function () {

var id = $(this).data('id');
var myurl = "<?php echo base_url('rawmaterial/edit/'); ?>" + id;
$.ajax({
    type: 'POST',
    url: myurl,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
        // console.log(response);
        $('#editraw_material input[name="name"]').val(response.name);
        $('#editraw_material input[name="quantity"]').val(response.quantity);
        $('#editraw_material input[name="threshold"]').val(response.threshold);
        $('[name="unit"] option[value="' + response.unit + '"]').prop('selected', true);
        $('#editraw_material').modal('show');
    }

});

$('#editraw_material form').attr('action', '<?php echo base_url("rawmaterial/update/"); ?>' + id);

});
</script>