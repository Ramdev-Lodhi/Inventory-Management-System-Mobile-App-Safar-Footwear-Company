<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    function get_size_by_articleId() {
        var temp = $('#article').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>jobsheet/get_size_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>jobsheet/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color').html(data);
            }
        });
    }

    $(document).on('click', '.edit', function () {

        var id = $(this).data('id');
        var myurl = "<?php echo base_url('jobsheet/edit/'); ?>" + id;
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {

                console.log(response);



                $('[name="job_type"] option[value="' + response.job_type + '"]').prop('selected', true);
                $('[name="article"] option[value="' + response.article_id + '"]').prop('selected', true);
                $('[name="contractor"] option[value="' + response.contractor_name + '"]').prop('selected', true);
                $('#editjobsheet input[name="no_of_pairs"]').val(response.no_of_pairs);
                // $('#no_of_pairs option[value="' + response.no_of_pairs + '"]').prop('selected', true);





                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>jobsheet/get_size_by_edit_articleId/" + response.article_id + "/" + response.size,
                    success: function (data) {
                        // console.log(data);
                        $('#size_edit').html(data);


                    }
                });
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>jobsheet/get_color_by_edit_articleId/" + response.article_id + "/" + response.color_id,
                    success: function (data) {
                        // console.log(data);
                        $('#color_edit').html(data);


                    }
                });


                $('#editjobsheet').modal('show');


            }


        });


        $('#editjobsheet form').attr('action', '<?php echo base_url("jobsheet/update/"); ?>' + id);




    });
</script>