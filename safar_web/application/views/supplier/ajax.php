<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    function change() {
        $('#a').show();
        $('#b').hide();
    }
    //show create modal
    function submitForm() {
        if ($('#first').is(':checked')) {
            $('#a form').submit(); // Submit the first form inside the div with id 'a'
        } else {
            $('#b form').submit(); // Submit the second form inside the div with id 'b'
        }
    }
    function change_supplier(value) {
        if (value == 'first') {
            $('#a').show();
            $('#b').hide();
        } else {
            $('#a').hide();
            $('#b').show();
        }
    }

    
    //show edit modal
    $(document).on('click', '.edit1', function () {

        var id = $(this).data('id');
        var myurl = "<?php echo base_url('supplier/edit1/'); ?>" + id;
        // console.log(myurl);
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {

                console.log(response);
                $('[name="supplier_edit"][value="' + response.supplier + '"]').prop('checked', true);
         
                    $('#raw_material_a_edit option[value="' + response.rawmaterial_id  + '"]').prop('selected', true);
                    $('#raw_material_b_edit option[value="' + response.rawmaterial_id  + '"]').prop('selected', true);
                    $('#category_a_edit option[value="' + response.category_id  + '"]').prop('selected', true);
                    $('#category_b_edit option[value="' + response.category_id  + '"]').prop('selected', true);
                    $('#editsupplier input[name="name"]').val(response.name);
                    $('#editsupplier input[name="address"]').val(response.address);
                    $('#editsupplier input[name="city"]').val(response.city);
                    $('#editsupplier input[name="email"]').val(response.email);
                    $('#editsupplier input[name="mobile_no"]').val(response.mobile_no);
                 
                    $('#a_edit').show();
                    $('#b_edit').hide();
              
                $('#editsupplier').modal('show');


            }


        });


        $('#a_edit form').attr('action', '<?php echo base_url("supplier/update/"); ?>' + id);



    });
    $(document).on('click', '.edit2', function () {

        var id = $(this).data('id');
        var myurl = "<?php echo base_url('supplier/edit2/'); ?>" + id;
        // console.log(myurl);
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {

                console.log(response);
                $('[name="supplier_edit"][value="' + response.supplier + '"]').prop('checked', true);
         

                    $('#raw_material_a_edit option[value="' + response.rawmaterial_id  + '"]').prop('selected', true);
                    $('#raw_material_b_edit option[value="' + response.rawmaterial_id  + '"]').prop('selected', true);
                    $('#category_a_edit option[value="' + response.category_id  + '"]').prop('selected', true);
                    $('#category_b_edit option[value="' + response.category_id  + '"]').prop('selected', true);
                    $('#editsupplier input[name="name"]').val(response.name);
                    $('#editsupplier input[name="address"]').val(response.address);
                    $('#editsupplier input[name="city"]').val(response.city);
                    $('#editsupplier input[name="email"]').val(response.email);
                    $('#editsupplier input[name="mobile_no"]').val(response.mobile_no);

                    $('#a_edit').hide();
                    $('#b_edit').show();
                
              
                $('#editsupplier').modal('show');


            }


        });


        $('#b_edit form').attr('action', '<?php echo base_url("supplier/update/"); ?>' + id);



    });


    function submitForm_edit() {

        var supplier = $('input[name="supplier_edit"]:checked').val();
        if (supplier == 'first') {
            $('#a_edit form').submit();
        } else {
            $('#b_edit form').submit();
        }

    }


    // Function to toggle between first and second supplier
    function change_supplier_edit(value) {
        
        if (value == 'first') {
            $('#a_edit').show();
            $('#b_edit').hide();
        } else {
            $('#a_edit').hide();
            $('#b_edit').show();
        }
    }

</script>