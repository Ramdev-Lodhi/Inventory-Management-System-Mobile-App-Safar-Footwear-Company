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
    <div class="container-fluid">

      <!-- row -->
      <div class="row column1">
        <div class="col-md-12" style="padding:20px;">
          <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
              <div class=" col-lg-12 my-2">
                <h2 class="text-center mb-3">Add New Article Size</h2>
              </div>
              <div class="d-flex justify-content-between ">
                <h4>Fill the details of new Article</h4>
                <a class="btn btn-warning" href="<?php echo base_url('articlesize'); ?>"> <i
                    class="fas fa-angle-left"></i> Back</a>
              </div>
            </div>
            <div class="padding_infor_info">

              <form method="post" action="<?php echo base_url('articlesize/store'); ?>">
                <div class="form-group">
                  <label>Article Name</label>
                  <input class="form-control" type="text" name="name">
                </div>
                <!-- Select type  -->
                <div class="form-group">
                  <label>Type </label>&nbsp &nbsp
                  <select name="type" style="padding:10px 30px;">
                    <?php foreach ($type as $t) { ?>
                      <option value="<?= $t->id ?>"><?= $t->name ?></option>
                    <?php } ?>
                  </select>
                </div>
                <!-- Select category  -->
                <div class="form-group">
                  <label>Category Id</label>&nbsp &nbsp
                  <select name="category" style="padding:10px 30px;">
                    <?php foreach ($category as $c) { ?>
                      <option value="<?= $c->id ?>"><?= $c->name ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>MRP (in Rs.)</label>
                  <input class="form-control" type="text" name="mrp">
                </div>

                <div class="form-group">
                  <label>Box Package</label> &nbsp &nbsp
                  <input type="radio" id="yes" name="package_box" value="1"> <label>YES</label> &nbsp &nbsp
                  <input type="radio" id="no" name="package_box" value="0"> <label>NO</label>
                </div>

                <div class="form-group">
                  <label>Loose Package</label> &nbsp &nbsp
                  <input type="radio" id="yes" name="package_loose" value="1"> <label>YES</label> &nbsp &nbsp
                  <input type="radio" id="no" name="package_loose" value="0"> <label>NO</label>
                </div>

                <div class="form-group">
                  <label>No of Pairs in Box</label>
                  <input class="form-control" type="text" name="no_of_pairs_box">
                </div>
                <div class="form-group">
                  <label>No of Pairs in Loose</label>
                  <input class="form-control" type="text" name="no_of_pairs_loose">
                </div>

                <div class="form-group">
                  <label>Is Active</label> &nbsp &nbsp
                  <input type="radio" id="active" name="is_active" value="1" checked> <label>TRUE</label>&nbsp &nbsp
                  <input type="radio" id="inactive" name="is_active" value="0"> <label>FALSE</label>
                </div>

                <div class="form-group">
                  <label>Photo</label>
                  <input class="form-control" type="text" name="photo">
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
    <!-- end row -->
  </div>
  <!-- footer -->

</div>

<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>