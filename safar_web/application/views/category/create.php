<div class="row column1">
  <div class="col-md-12" style="padding:20px;">
    <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="col-lg-12 my-2">
            <h2 class="text-center mb-3">Add New Category</h2>
          </div>
          <div class="d-flex justify-content-end ">

            <a class="btn btn-warning btn-lg" href="<?php echo base_url('category'); ?>"> <i class="fas fa-angle-left"></i>
              Back</a>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="padding_infor_info">
            <form method="post" action="<?php echo base_url('category/store'); ?>">

    
              <div class="form-group">
                <label>Category Name</label>
                <input class="form-control" type="text" name="name" oninput="this.value=this.value.toUpperCase()" style="text-transform:uppercase">
              </div>
      


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

<!-- end dashboard inner -->
<!-- <?php //$this->load->view('includes/footer'); ?> -->