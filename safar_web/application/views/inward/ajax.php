<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>


<script>
    function change() {
        $('#a').show();
        $('#b').hide();
    }
    //show create modal
    function submitForm() {
        if ($('#quality_first').is(':checked')) {
            $('#a form').submit(); // Submit the first form inside the div with id 'a'
        } else {
            $('#b form').submit(); // Submit the second form inside the div with id 'b'
        }
    }
    function change_quality(value) {
        if (value == 'first') {
            $('#a').show();
            $('#b').hide();
        } else {
            $('#a').hide();
            $('#b').show();
        }
    }

    function get_size_by_articleId() {
        var temp = $('#article').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_size_by_articleId/" + articleId,
            success: function (data) {
                $('#size').html(data);
            }
        });
    }

    function get_color_by_articleId() {
        var temp = $('#article').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color').html(data);
            }
        });
    }
    function get_size_by_b_articleId() {
        var temp = $('#article_b').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_size_by_articleId/" + articleId,
            success: function (data) {
                $('#size_b').html(data);
            }
        });
    }
    function get_color_by_b_articleId() {
        var temp = $('#article_b').val();
        var articleId = temp.split('~')[0];
        console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color_b').html(data);
            }
        });
    }

    function get_no_of_pairs_by_articleId() {
        // var temp = $('#article').val();
        // var articleId = temp.split('~')[0];
        // $.ajax({
        //   type: "GET",
        //   url: "<?= base_url() ?>inward/get_no_of_pairs_by_articleId/" + articleId,
        //   success: function (data) {
        //     $('#no_of_pairs').html(data);
        //   }
        // });
    }

    //end create modal

    //show edit modal
    $(document).on('click', '.edit', function () {

        var id = $(this).data('id');
        var myurl = "<?php echo base_url('inward/edit/'); ?>" + id;
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {
                var temp = response['da']['qr_id'].split('~');
          var type= temp[8];
          var parts = temp[0].split('-');
            var label_id= parts[3];

                console.log(temp);
                console.log(label_id);

                $('[name="quality"][value="' + response['da'].quality + '"]').prop('checked', true);
                $('[name="label_type"][value="' + type + '"]').prop('checked', true);
                if (response['da'].quality == 'first') {

                    $('[name="article"] option[value="' + response['da'].a_id + "~" + response['da'].a_name + '"]').prop('selected', true);
                    $('#article_b_edit option[value="' + response['da'].a_id + "~" + response['da'].a_name + '"]').prop('selected', true);
                    $('#no_of_pairs option[value="' + response['da'].no_of_pairs + '"]').prop('selected', true);
                    $('#editinward input[name="godown_id"]').val(response['da'].godown_id);
                    $('#editinward input[name="status"]').val(response['da'].status);
                    $('#editinward input[name="label_id"]').val(label_id);
                    $('#editinward input[name="godown_id_b"]').val(response['da'].godown_id);
                    $('#editinward input[name="status_b"]').val(response['da'].status);
                    $('#editinward input[name="label_id_b"]').val(label_id);
                    $('#a_edit').show();
                    $('#b_edit').hide();


                } else {
                    $('[name="article"] option[value="' + response['da'].a_id + "~" + response['da'].a_name + '"]').prop('selected', true);
                    $('#no_of_pairs option[value="' + response['da'].no_of_pairs + '"]').prop('selected', true);
                    $('#article_b_edit option[value="' + response['da'].a_id + "~" + response['da'].a_name + '"]').prop('selected', true);
                    $('#editinward input[name="godown_id_b"]').val(response['da'].godown_id);
                    $('#editinward input[name="status_b"]').val(response['da'].status);
                    $('#editinward input[name="label_id_b"]').val(label_id);
                    $('#editinward input[name="godown_id"]').val(response['da'].godown_id);
                    $('#editinward input[name="status"]').val(response['da'].status);
                    $('#editinward input[name="label_id"]').val(label_id);
                    $('#a_edit').hide();
                    $('#b_edit').show();
                }
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>inward/get_size_by_edit_articleId/" + response['da'].a_id + "/" + response['da'].size,
                    success: function (data) {
                        // console.log(data);
                        $('#size_a_edit').html(data);
                        $('#size_b_edit').html(data);

                    }
                });
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>inward/get_color_by_edit_articleId/" + response['da'].a_id + "/" + response['da'].a_color_id,
                    success: function (data) {
                        // console.log(data);
                        $('#color_a_edit').html(data);
                        $('#color_b_edit').html(data);

                    }
                });


                $('#editinward').modal('show');


            }


        });


        $('#a_edit form').attr('action', '<?php echo base_url("inward/update/"); ?>' + id);
        $('#b_edit form').attr('action', '<?php echo base_url("inward/update/"); ?>' + id);



    });


    function submitForm_edit() {

        var quality = $('input[name="quality"]:checked').val();
        if (quality == 'first') {
            $('#a_edit form').submit();
        } else {
            $('#b_edit form').submit();
        }

    }


    // Function to toggle between first and second quality
    function change_quality_edit(value) {
        if (value == 'first') {
            $('#a_edit').show();
            $('#b_edit').hide();
        } else {
            $('#a_edit').hide();
            $('#b_edit').show();
        }
    }

    function get_size_by_edit_articleId() {
        var temp = $('#article_a_edit').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_size_by_articleId/" + articleId,
            success: function (data) {
                // console.log(data);
                $('#size_a_edit').html(data);

            }
        });
    }

    function get_color_by_edit_articleId() {
        var temp = $('#article_a_edit').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color_a_edit').html(data);

            }
        });
    }
    function get_size_by_bedit_articleId() {
        var temp = $('#article_b_edit').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_size_by_articleId/" + articleId,
            success: function (data) {
                // console.log(data);
                $('#size_b_edit').html(data);

            }
        });
    }

    function get_color_by_bedit_articleId() {
        var temp = $('#article_b_edit').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>inward/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color_b_edit').html(data);

            }
        });
    }
</script>