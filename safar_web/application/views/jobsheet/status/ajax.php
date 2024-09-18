<?php $this->load->view('includes/header')?>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).on('click', '.details', function () {
    var id = $(this).data('id');
    var myurl = "<?php echo base_url('jobsheet/view_status/'); ?>" + id;

    $.ajax({
        type: 'POST',
        url: myurl,
        dataType: 'html', // Expecting HTML response
        data: { id: id },
        success: function (response) {
            $('#table-container tbody').html(response); // Append tbody data to the table
        }
    });
});
</script>
<script>
function status(id){

var toggle=document.getElementById(id).checked;
	var myurl = "<?php echo base_url('jobsheet/change_jobsheet_status/'); ?>";
	 if(id!="")
        {
        	$.ajax({
        		url:myurl,
        		type:"POST",
        		data : {
        			"id" :id,
        			"toggle" : toggle
        		},
        		datatype : 'json',
        		success: function(data){
        				// swal("done!","status is on ");

        		},
        		error: function(error){
        			// document.getElementById(id).style.borderColor = 'red';
        		}
        	});
		}

}
</script>