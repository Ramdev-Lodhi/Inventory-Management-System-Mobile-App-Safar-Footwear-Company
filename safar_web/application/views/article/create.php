
  
  <div class="col-md-12" style="padding :20px">
    <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
        <div class="d-flex justify-content-between ">
          <h4 style="color: green">FILL THE DETAILS FOR NEW ARTICLE</h4>
          <a class="btn btn-warning btn-lg" href="<?php echo base_url('article'); ?>"> <i class="fas fa-angle-left"></i>
            Back</a>
        </div>
      </div>
      <div class="padding_infor_info">
        <form method="post" action="<?php echo base_url('article/store'); ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label>Article Name</label>
            <input class="form-control" type="text" name="name" required>
          </div>
          <!-- Select type  -->
          <div class="form-group">
            <label>Type </label>&nbsp &nbsp
            <select class="form-select" name="type">
              <?php foreach ($type as $t) { ?>
                <option value="<?= $t->id ?>"><?= $t->name ?></option>
              <?php } ?>
            </select>
          </div>
          <!-- Select category  -->
          <div class="form-group">
            <label>Category Id</label>&nbsp &nbsp
            <select class="form-select" name="category">
              <?php foreach ($category as $c) { ?>
                <option value="<?= $c->id ?>"><?= $c->name ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>MRP (in Rs.)</label>
            <input class="form-control" type="text" name="mrp" required>
          </div>

          <div class="form-group">
            <label>Package</label> &nbsp &nbsp
            <select class="form-select" name="package">
                <option value="BOX">BOX</option>
                <option value="LOOSE">LOOSE</option>
            </select>
          </div>

          <div class="form-group">
            <label>No of Pairs</label>
            <input class="form-control" type="text" name="no_of_pairs" required>
          </div>

          <div class="form-group">
            <label>Is Active</label> &nbsp &nbsp
            <input type="radio" id="active" name="is_active" value="1" checked>
            <label>TRUE</label>&nbsp &nbsp
            <input type="radio" id="inactive" name="is_active" value="0"> <label>FALSE</label>
          </div>

          <div class="form-group">
            <label>Photo</label>
            <div class="add-product-image">
              <div class="images">

                <div class="product-images-div">
                </div>
                <div class="add-images">
                  <div class="add-image">
                    <div class="drop-zone-small">
                      <span class="drop-zone-text">Drop file here or click to upload</span>
                      <input type="file" name="product-image[]" class="drop-zone-input" id="drop-zone-input-1" 
                        onchange="previewImage(this.files)">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
          <div class="col-md-12 text-right"  class="form-group">
            <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-check"></i> Submit
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
