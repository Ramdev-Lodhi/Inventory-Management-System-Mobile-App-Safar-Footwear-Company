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
      <div class="row column1">
        <div class="col-md-12" style="padding:20px;">
          <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
              <div class="col-lg-12 my-2">
                <center>
                  <h3> EDIT ARTICLE COLOR IN MASTER TABLES </h3>
                </center>
              </div>
              <div class="d-flex justify-content-end ">
            
                <a class="btn btn-warning" href="<?php echo base_url('/articlecolor'); ?>"> <i
                    class="fas fa-angle-left"></i>
                  Back</a>
              </div>
            </div>
            <div class="col-lg-12">
              <!-- <div class="d-flex justify-content-between ">
                        <h4>Edit </h4>
                        <a class="btn btn-warning" href="<?php echo base_url('/articlecolor'); ?>"> <i
                            class="fas fa-angle-left"></i> Back</a>
                      </div> -->
              <div class="padding_infor_info">
                <form method="post" action="<?php echo base_url('articlecolor/update/' . $data->id); ?>">
                  <div class="form-group">
                    <label>Article Id</label>
                    <input class="form-control" type="text" name="article_id" readonly
                      value="<?php echo $data->article_id ?>">
                    <label>Color Name</label>
                    <input class="form-control" type="text" name="color" value="<?php echo $data->color; ?>">
                    <label>Color Photo</label>
                    <input class="form-control" type="text" name="c_photo" value="<?php echo $data->c_photo; ?>">
                    <br />
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


<?php $this->load->view('includes/footer'); ?>