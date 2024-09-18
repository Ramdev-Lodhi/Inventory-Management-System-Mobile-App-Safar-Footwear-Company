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
            url: "<?= base_url() ?>label/get_size_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>label/get_color_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>label/get_size_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>label/get_color_by_articleId/" + articleId,
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
        //   url: "<?= base_url() ?>label/get_no_of_pairs_by_articleId/" + articleId,
        //   success: function (data) {
        //     $('#no_of_pairs').html(data);
        //   }
        // });
    }

    //end create modal

    //show edit modal
    $(document).on('click', '.edit', function () {

        var id = $(this).data('id');
        var myurl = "<?php echo base_url('label/edit/'); ?>" + id;
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {

                // console.log(response['article']);
                $('[name="quality"][value="' + response['da'].quality + '"]').prop('checked', true);
                $('[name="label_type"][value="' + response['da'].label_type + '"]').prop('checked', true);
                if (response['da'].quality == 'first') {

                    $('[name="article"] option[value="' + response['da'].article_id + "~" + response['da'].name + '"]').prop('selected', true);
                    $('#article_b_edit option[value="' + response['da'].article_id + "~" + response['da'].name + '"]').prop('selected', true);
                    $('#no_of_pairs option[value="' + response['da'].no_of_pairs + '"]').prop('selected', true);
                    $('#a_edit').show();
                    $('#b_edit').hide();


                } else {
                    $('[name="article"] option[value="' + response['da'].article_id + "~" + response['da'].name + '"]').prop('selected', true);
                    $('#no_of_pairs option[value="' + response['da'].no_of_pairs + '"]').prop('selected', true);
                    $('#article_b_edit option[value="' + response['da'].article_id + "~" + response['da'].name + '"]').prop('selected', true);

                    $('#a_edit').hide();
                    $('#b_edit').show();
                }
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>label/get_size_by_edit_articleId/" + response['da'].article_id + "/" + response['da'].size,
                    success: function (data) {
                        // console.log(data);
                        $('#size_a_edit').html(data);
                        $('#size_b_edit').html(data);

                    }
                });
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>label/get_color_by_edit_articleId/" + response['da'].article_id + "/" + response['da'].article_color_id,
                    success: function (data) {
                        // console.log(data);
                        $('#color_a_edit').html(data);
                        $('#color_b_edit').html(data);

                    }
                });


                $('#editlable').modal('show');


            }


        });


        $('#a_edit form').attr('action', '<?php echo base_url("label/update/"); ?>' + id);
        $('#b_edit form').attr('action', '<?php echo base_url("label/update/"); ?>' + id);



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
            url: "<?= base_url() ?>label/get_size_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>label/get_color_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>label/get_size_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>label/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color_b_edit').html(data);

            }
        });
    }
    $(document).on('click', '.qr', function () {
        var id = $(this).data('id');
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>label/qrcode_link/" + id,
            success: function (data) {
                // console.log(data);
                $('#qrlable input[name="qr"]').val(data);

            }
        });
    })
</script>