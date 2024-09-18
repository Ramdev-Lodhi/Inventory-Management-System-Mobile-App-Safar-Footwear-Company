<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Add New Article</title>
</head>

<!-- Sidebar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->

<!-- topbar -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end topbar -->

<!-- dashboard inner -->
<div class="midde_cont">
  <div class="row">
    <!-- Page Content  -->
    <div class="container-fluid">
      <div class="row column1">
        <div class="col-md-12" style="padding:20px;">
          <div class="white_shd full margin_bottom_30">
            <div class="row">
              <div class="full graph_head">
                <div class="col-lg-12 my-2">
                  <h2 class="text-center mb-3">Add New Article Color</h2>
                </div>
                <div class="d-flex justify-content-end ">
                  
                  <a class="btn btn-warning" href="<?php echo base_url('articlecolor'); ?>"> <i
                      class="fas fa-angle-left"></i> Back</a>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="padding_infor_info">
                  <form method="post" action="<?php echo base_url('articlecolor/store'); ?>">

                    <!-- Select article  -->
                    <div class="form-group">
                      <label>Select Article Name </label>&nbsp &nbsp
                      <select name="a_id" style="padding:10px 30px;">
                        <?php foreach ($article as $a) { ?>
                          <option value="<?= $a->id ?>"><?= $a->name ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Color Name</label>
                      <input class="form-control" type="text" name="color">
                    </div>
                    <div class="form-group">
                      <label>Color Photo</label>
                      <input class="form-control" type="text" name="c_photo">
                    </div>


                    <div class="form-group">
                      <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Submit </button>
                    </div>

                  </form>


                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>