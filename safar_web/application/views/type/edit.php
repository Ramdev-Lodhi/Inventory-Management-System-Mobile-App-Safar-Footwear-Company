<div class="row column1">
  <div class="col-md-12" style="padding:20px;">
    <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
        <div class="col-lg-12 my-2">
          <center>
            <h3> EDIT TYPE</h3>
          </center>
        </div>
        <div class="d-flex justify-content-end ">

          <a class="btn btn-warning btn-lg" href="<?php echo base_url('/type'); ?>"> <i class="fas fa-angle-left"></i>
            Back</a>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="padding_infor_info">
          <form method="post" action="<?php echo base_url('type/update/' ); ?>">
            <div class="form-group">
              <!-- <label>Article Id</label> -->
              <input class="form-control" type="hidden" name="type_id" readonly
                value="">
              <label>TYPE</label>
              <input class="form-control " type="text" name="name" value="" oninput="this.value=this.value.toUpperCase()" style="text-transform:uppercase">
                </div>
              <br />
              <div class="col-md-12 text-right"  class="form-group">
            <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-check"></i> Submit
            </button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- <?php //$this->load->view('includes/footer'); ?> -->