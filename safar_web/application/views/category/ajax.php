<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  function editcategory(id) {
    var myurl = "<?php echo base_url('category/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {
console.log(data);
        // Update modal fields with received data
        $('#editcategory input[name="id"]').val(data.id);
        $('#editcategory input[name="name"]').val(data.name);


    

        // Set form action to update with the correct article ID
        $('#editcategory form').attr('action', '<?php echo base_url("category/update/"); ?>' + data.id);
        // Show the modal
        $('#editcategory').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  }

</script>