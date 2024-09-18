<!-- dashboard inner -->
<div class="col-md-12" style="padding :20px">
  <div class="white_shd full margin_bottom_30">
    <div class="full graph_head">
      <!-- <div class=" col-lg-12 my-2">
        <h4 class="text-center mb-3"> EDIT ARTICLE IN MASTER TABLES </h4>
      </div> -->
      <div class="d-flex justify-content-between ">
      <h4 style="color: green">EDIT THE DETAILS FOR THE ARTICLE</h4>
        <a class="btn btn-warning btn-lg" href="<?php echo base_url('/article'); ?>"> <i class="fas fa-angle-left"></i>
          Back</a>
      </div>
    </div>
    <div class="padding_infor_info">
      <div class="table-responsive">
        <form method="post" action="<?php echo base_url('article/update/'); ?>" enctype="multipart/form-data">
          <div class="form-group">
            <!-- <label>Article Id</label> -->
            <input class="form-control" type="hidden" name="id" readonly>
            <label>Article Name</label>
            <input class="form-control" type="text" name="name">
            <label>Article Type</label>
            <input class="form-control" type="text" name="type">
            <label>Article Category</label>
            <input class="form-control" type="text" name="category">
            <label>MRP (in Rs.)</label>
            <input class="form-control" type="text" name="mrp">
            <label>Packing</label>
            <input class="form-control" type="text" name="package">
            <label>No_of_pairs</label>
            <input class="form-control" type="text" name="no_of_pairs">
            <label>Photo</label>
            <div class="d-flex justify-content-between">
            <div class="article-image">
              <img id="image" src="" alt="Updated Image" >
            </div>
            <span><i class="fa fa-arrows-h" style="margin-top:100px;"></i></span>
            <div class="product-images-div1">
            </div>
            </div>
            <div class="add-product-image">
              <div class="images">
                <div class="add-images_edit">
                  <div class="add-images_edit">
                    <div class="drop-zone-small">
                      <span class="drop-zone-text">Drop file here or click to upload and Change Photo</span>
                      <input class="form-control" type="hidden" name="photo">
                      <input type="file" name="product-image[]" class="drop-zone-input" id="drop-zone-input-1"
                        onchange="previewImage1(this.files)">
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <label>Is Active</label> <br />
            <input type="radio" id="active" name="is_active" value="1"> <label for="active">TRUE</label>
            <input type="radio" id="inactive" name="is_active" value="0"> <label for="inactive">FALSE</label><br />
            <div class="col-md-12 text-right"  class="form-group">
            <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-check"></i> Submit
            </button>
            </div>
        </div>

        </form>
      </div>
    </div>
  </div>

</div>
<!-- end dashboard inner -->