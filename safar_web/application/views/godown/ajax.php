<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  function edit_godown(id) {
    var myurl = "<?php echo base_url('godown/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {
console.log(data);
      
        $('#editgodown input[name="godown"]').val(data.name);
        // Set form action to update with the correct article ID
        $('#editgodown form').attr('action', '<?php echo base_url("godown/update/"); ?>' + data.id);
        // Show the modal
        $('#editgodown').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  }

</script>