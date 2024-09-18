<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  function edittype(id) {
    var myurl = "<?php echo base_url('type/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {
console.log(data);
        // Update modal fields with received data
        $('#edittype input[name="id"]').val(data.id);
        $('#edittype input[name="name"]').val(data.name);


    

        // Set form action to update with the correct article ID
        $('#edittype form').attr('action', '<?php echo base_url("type/update/"); ?>' + data.id);
        // Show the modal
        $('#edittype').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  }

</script>