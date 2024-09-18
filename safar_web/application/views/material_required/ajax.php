<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
function get_color_by_articleId() {
        var temp = $('#article').val();
        var articleId = temp.split('~')[0];
        // console.log(temp);
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>rawmaterial/get_color_by_articleId/" + articleId,
            success: function (data) {
                $('#color').html(data);
            }
        });
    }
    </script>
    <script>
  $(document).on('click', '.edit', function () {

    var id = $(this).data('id');
    var myurl = "<?php echo base_url('rawmaterial/material_required_edit/'); ?>" + id;
    $.ajax({
        type: 'POST',
        url: myurl,
        dataType: 'json',
        data: { id: id },
        success: function (response) {
          console.log(response);
          $('[name="article"] option[value="' + response.a_id + "~" + response.a_name + '"]').prop('selected', true);
        $('#editmaterial_required input[name="Polyurethane"]').val(response.polyurethane);
        $('#editmaterial_required input[name="Isocyanates"]').val(response.isocyanates);
        $('#editmaterial_required input[name="Catalysts"]').val(response.catalysts);
        $('#editmaterial_required input[name="rising_chemical"]').val(response.rising_chemical);
        $('#editmaterial_required input[name="skin_chemical"]').val(response.skin_chemical);
        $('#editmaterial_required input[name="releasing_agent"]').val(response.releasing_agent);
        $('#editmaterial_required input[name="MCL"]').val(response.mcl);
        $('#editmaterial_required input[name="ELFI_GLUE"]').val(response.elfi_glue);
        $('#editmaterial_required input[name="PVC_BAGS"]').val(response.pvc_bags);
        $('#editmaterial_required input[name="LIFTER"]').val(response.lifter);
        $('#editmaterial_required input[name="BUTTER_PAPER"]').val(response.butter_paper);
        $('#editmaterial_required input[name="LD_BAGS"]').val(response.ld_bags);
        $('#editmaterial_required input[name="OUTTER_LABEL"]').val(response.outter_label);
        $('#editmaterial_required input[name="INNER_LABEL"]').val(response.inner_label);
        $('#editmaterial_required input[name="REXINE"]').val(response.rexine);
        $.ajax({
                    type: "GET",
                    url: "<?= base_url() ?>rawmaterial/get_color_by_edit_articleId/" + response.a_id + "/" + response.a_color_id,
                    success: function (data) {
                        // console.log(data);
                        $('#color_edit').html(data);
                    

                    }
                });
   
        $('#editmaterial_required').modal('show');
      }

    });

    $('#editmaterial_required form').attr('action', '<?php echo base_url("rawmaterial/material_required_update/"); ?>' + id);

  });
</script>