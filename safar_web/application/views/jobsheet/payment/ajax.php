<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
 $(document).on('click', '.edit', function () {

        var id = $(this).data('id');
        var temp = id.split("/");
        var job_id= temp[0];
        var a_id=temp[1];
        var contractor=temp[2];
        var color_id=temp[3];
        var payment_status=temp[4];
        console.log(temp)
        var myurl = "<?php echo base_url('jobsheet/payment_view/'); ?>" + job_id+'/'+a_id+'/'+contractor+'/'+color_id;
        $.ajax({
            type: 'POST',
            url: myurl,
            dataType: 'json',
            data: { id: id },
            success: function (response) {
                console.log(response);
                $('[name="payment"][value="' + response.data.payment_status + '"]').prop('checked', true)
                $('#viewpayment input[name="no_of_pairs"]').val(response.data.no_of_pairs);
                $('#viewpayment input[name="date"]').val(response.data.payment_date);
                $('#viewpayment input[name="job_type"]').val(response.data.job_type);
                $('#viewpayment input[name="color"]').val(response.color.color);
                $('#viewpayment input[name="size"]').val(response.data.size);
                $('#viewpayment input[name="contractor"]').val(response.contractor.contractor_name);
                var amounts = response.amount[0];
            var sum = 0;
            for (var key in amounts) {
                if (amounts.hasOwnProperty(key) && key !== 'a_id') {
                    sum += parseFloat(amounts[key]);
                }
            }
            var total = response.data.no_of_pairs * sum ;
            // Setting the calculated sum to the input field named "total"
            $('#viewpayment input[name="amount"]').val(total);;
                $('#viewpayment').modal('show');
            }
        });
        $('#viewpayment form').attr('action', '<?php echo base_url("jobsheet/cahange_payment_status/"); ?>' + job_id+'/'+payment_status);
    });
</script>