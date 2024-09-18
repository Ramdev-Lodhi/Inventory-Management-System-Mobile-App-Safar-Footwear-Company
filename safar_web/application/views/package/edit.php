<div class="row column1">
  <div class="col-md-12" style="padding:20px;">
    <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
        <div class="col-lg-12 my-2">
          <center>
            <h3> EDIT Package Size</h3>
          </center>
        </div>
        <div class="d-flex justify-content-end ">

          <a class="btn btn-warning" href="<?php echo base_url('/package'); ?>"> <i class="fas fa-angle-left"></i>
            Back</a>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="padding_infor_info">
          <form method="post" action="<?php echo base_url('package/update/' ); ?>">
            <div class="form-group">
                            <label>Category Id</label>&nbsp &nbsp
                            <select class="form-select" name="category" required>
                                <option> Select Category</option>
                                <?php foreach ($category as $c) { ?>
                                    <option value="<?= $c->id ?>"><?= $c->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Package Size</label>
                            <input class="form-control" type="text" name="size" required>
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