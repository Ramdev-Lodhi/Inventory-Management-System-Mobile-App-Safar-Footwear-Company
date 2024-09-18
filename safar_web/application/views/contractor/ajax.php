<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
 $(document).on('click', '.edit', function () {

var id = $(this).data('id');
    var myurl = "<?php echo base_url('contractor/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {
console.log(data);
      
        $('#editcontractor input[name="contractor"]').val(data.contractor_name);
        // Set form action to update with the correct article ID
        $('#editcontractor form').attr('action', '<?php echo base_url("contractor/update/"); ?>' + data.id);
        // Show the modal
        $('#editcontractor').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  })

</script>