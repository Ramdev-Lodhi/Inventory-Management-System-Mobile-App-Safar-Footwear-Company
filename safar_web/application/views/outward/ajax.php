<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(document).on('click', '.edit', function () {

var id = $(this).data('id');
var myurl = "<?php echo base_url('outward/edit/'); ?>" + id;
$.ajax({
    type: 'POST',
    url: myurl,
    dataType: 'json',
    data: { id: id },
    success: function (response) {
        console.log(response);
        $('#editoutward input[name="id"]').val(response.inward_id);
        $('#editoutward').modal('show');
    }

});

$('#editoutward form').attr('action', '<?php echo base_url("outward/update/"); ?>' + id);

});
</script>