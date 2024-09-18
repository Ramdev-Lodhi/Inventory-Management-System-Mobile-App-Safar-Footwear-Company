<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Edit Article</title>
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
  <div class="container-fluid">
    <!-- row -->
    <div class="row column1" >
      <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
          <div class="full graph_head">
            <div class=" col-lg-12 my-2">
              <h2 class="text-center mb-3">EDIT ARTICLE IN MASTER TABLES</h2>
            </div>
            <div class="d-flex justify-content-end ">
              <a class="btn btn-warning" href="<?php echo base_url('/articlesize'); ?>"> <i
                  class="fas fa-angle-left"></i>
                Back</a>
            </div>
          </div>
          <div class="padding_infor_info">
             
        
                <form method="post" action="<?php echo base_url('articlesize/update/' . $data->id); ?>">
                  <div class="form-group">
                    <label>Article Id</label>
                    <input class="form-control" type="text" name="id" value="<?php echo $data->id ?>">
                    <label>Article Name</label>
                    <input class="form-control" type="text" name="name" value="<?php echo $data->name; ?>">
                    <label>Article Type</label>
                    <input class="form-control" type="text" name="type" value="<?php echo $data->type; ?>">
                    <label>Article Category</label>
                    <input class="form-control" type="text" name="category" value="<?php echo $data->category; ?>">
                    <label>MRP (in Rs.)</label>
                    <input class="form-control" type="text" name="mrp" value="<?php echo $data->mrp; ?>">
                    <label>Box Packing</label>
                    <input class="form-control" type="text" name="package_box"
                      value="<?php echo $data->package_box; ?>">
                    <label>Loose Packing</label>
                    <input class="form-control" type="text" name="package_loose"
                      value="<?php echo $data->package_loose; ?>">
                    <label>No_of_pairs_in_Box Packing</label>
                    <input class="form-control" type="text" name="no_of_pairs_box"
                      value="<?php echo $data->no_of_pairs_box; ?>">
                    <label>No_of_pairs_in_Loose Packing</label>
                    <input class="form-control" type="text" name="no_of_pairs_loose"
                      value="<?php echo $data->no_of_pairs_loose; ?>">
                    <label>Photo</label>
                    <input class="form-control" type="text" name="photo" value="<?php echo $data->photo; ?>">
                    <label>Is Active</label> <br />
                    <input type="radio" id="active" name="is_active" value="1" <?php if ($data->is_active == '1') {
                      echo 'checked';
                    } ?>> <label>TRUE</label>
                    <input type="radio" id="inactive" name="is_active" value="0" <?php if ($data->is_active == '0') {
                      echo 'checked';
                    } ?>> <label>FALSE</label><br />
                    <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Submit </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- footer -->

  </div>
</div>
<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>