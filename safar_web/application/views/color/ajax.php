<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  function edit_color(id) {
    var myurl = "<?php echo base_url('color/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {
console.log(data);
        // Update modal fields with received data
        $('[name="category_id"] option[value="' + data.category_id +'"]').prop('selected', true);
        // $('#editcolor input[name="id"]').val(data.category_id);
        $('#editcolor input[name="color"]').val(data.color);
        // Set form action to update with the correct article ID
        $('#editcolor form').attr('action', '<?php echo base_url("color/update/"); ?>' + data.id);
        // Show the modal
        $('#editcolor').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  }

</script>