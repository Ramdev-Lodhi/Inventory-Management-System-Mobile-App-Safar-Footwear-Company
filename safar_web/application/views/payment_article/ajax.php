<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    function get_size_by_articleId() {
        var temp = $('#article').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>payment_article/get_size_by_articleId/" + articleId,
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
            url: "<?= base_url() ?>payment_article/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color').html(data);
            }
        });
    }

    $(document).on('click', '.edit', function () {

        var id = $(this).data('id');
        var myurl = "<?php echo base_url('payment_article/edit/'); ?>" + id;
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {

                console.log(response);
                $('[name="article"] option[value="' + response.a_id + '"]').prop('selected', true);
                $('[name="contractor"] option[value="' + response.contractor_name + '"]').prop('selected', true);
                $('#editpayment input[name="cutting"]').val(response.Cutting);
                $('#editpayment input[name="embossing"]').val(response.Embossing);
                $('#editpayment input[name="packazing"]').val(response.Packazing);
                $('#editpayment input[name="pioring"]').val(response.Pioring);
                $('#editpayment input[name="printing"]').val(response.Printing);
                $('#editpayment input[name="production"]').val(response.Production);
                $('#editpayment input[name="sorting"]').val(response.Sorting);
                $('#editpayment input[name="stiching"]').val(response.Stiching);
                $('#editpayment input[name="store"]').val(response.Store);
                $('#editpayment input[name="trimming"]').val(response.Trimming);

                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>payment_article/get_size_by_edit_articleId/" + response.a_id + "/" + response.size,
                    success: function (data) {
                        // console.log(data);
                        $('#size_edit').html(data);


                    }
                });
                $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>payment_article/get_color_by_edit_articleId/" + response.a_id + "/" + response.a_color,
                    success: function (data) {
                        // console.log(data);
                        $('#color_edit').html(data);


                    }
                });


                $('#editpayment').modal('show');


            }


        });


        $('#editpayment form').attr('action', '<?php echo base_url("payment_article/update/"); ?>' + id);




    });
</script>
<script>
    $(document).ready(function () {
        $('#example tbody tr').each(function () {
            var total = 0;
            $(this).find('.value').each(function () {
                var value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            $(this).find('.total').text(total.toFixed(2));
        });
    });
</script>