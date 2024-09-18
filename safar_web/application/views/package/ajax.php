<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  function edit_package(id) {
    var myurl = "<?php echo base_url('package/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {
console.log(data);
        // Update modal fields with received data

            $('#editpackage input[name="size"]').val(data.size);
            $('[name="category"] option[value="'+data.category_id +'"]').prop('selected',true);
        // Set form action to update with the correct article ID
        $('#editpackage form').attr('action', '<?php echo base_url("package/update/"); ?>' + data.id);
        // Show the modal
        $('#editpackage').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  }

</script>