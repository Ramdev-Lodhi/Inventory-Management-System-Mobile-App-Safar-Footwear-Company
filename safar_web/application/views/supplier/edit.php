<!-- dashboard inner -->
<div class="col-md-12" style="padding:20px;">
  <div class="white_shd full margin_bottom_30">
    <div class="full graph_head">
      <div class="col-lg-12 my-2">
        <h1 class="text-center mb-3">Edit Supplier Details</h1>
      </div>
      <div class="d-flex justify-content-end ">
        <a class="btn btn-warning btn-lg" href="<?php echo base_url('supplier'); ?>"> <i class="fas fa-angle-left"></i>
          Back</a>
      </div>
    </div>
    <div class="padding_infor_info">
      <!-- <div class="form-group" style="font-weight:bold;">
        <label for="">Suppiler </label>
        <div>
          <label for="first" style="margin-right:10px">First</label>
          <input type="radio" name="supplier_edit" id="first" value="first"  onchange="change_supplier_edit(this.value);">

          <label for="second" style="margin-left:20px;margin-right:10px">Second</label>
          <input type="radio" name="supplier_edit" id="second" value="second" onchange="change_supplier_edit(this.value);">
        </div>
      </div> -->
      <div id='a_edit'>
        <form method="post" action="<?php echo base_url('supplier/update'); ?>">
          <div class="form-group">
          <label for="">Suppiler Type</label>
          <div>

            <label for="first" style="margin-right:10px">First</label>
            <input type="radio" name="supplier_edit" id="first" value="first"  onchange="change_supplier_edit(this.value);">
          </div>

          </div>
          <div class="form-group">
            <label>Raw Material <span style="color:red;"> * </span></label>

            <select name="raw_material" id="raw_material_a_edit" required
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;">
              <option >Select Material</option>
              <?php foreach ($raw_material1 as $a) { ?>
                <option value="<?= $a->id ?>"><?= $a->name ?></option>
              <?php } ?>
            </select>

          </div>
          <div class="form-group">
            <label>Category Name <span style="color:red;"> * </span></label>
            <select name="category" id="category_a_edit" required
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" >
              <option>Select Category</option>
              <?php foreach ($category as $c) { ?>
                <option value="<?= $c->id  ?>"><?= $c->name ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group first">
            <label>Name <span style="color:red;"> * </span></label>
            <input type="text" name="name"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group first">
            <label>Address <span style="color:red;"> * </span></label>
            <input type="text" name="address"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group first">
            <label>City <span style="color:red;"> * </span></label>
            <input type="text" name="city"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group">
            <label>Mobile Number <span style="color:red;"> * </span></label>
            <input type="number" name="mobile_no"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group">
            <label>Email <span style="color:red;"> * </span></label>
            <input type="email" name="email"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>
        </form>
      </div>
      <div id="b_edit" class="second">
        <form method="post" action="<?php echo base_url('supplier/update'); ?>">
          <div class="form-group">
            <label for="">Suppiler Type </label>
            <div>
              <label for="second" style="margin-left:20px;margin-right:10px">Second</label>
              <input type="radio" name="supplier_edit" id="second" value="second" onchange="change_supplier_edit(this.value);">

            </div>
          </div>
          <div class="form-group">
            <label>Raw Material</label>
            <select name="raw_material" id="raw_material_b_edit"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" required>
              <option>Select Material <span style="color:red;"> * </span></option>
              <?php foreach ($raw_material2 as $a) { ?>
                <option value="<?= $a->id  ?>"><?= $a->name ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Category Name <span style="color:red;"> * </span></label>
            <select name="category" id="category_b_edit"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" required>
              <option>Select Category</option>
              <?php foreach ($category as $c) { ?>
                <option value="<?= $c->id ?>"><?= $c->name ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Name <span style="color:red;"> * </span></label>
            <input type="text" name="name"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group">
            <label>Address <span style="color:red;"> * </span></label>
            <input type="text" name="address"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group">
            <label>City <span style="color:red;"> * </span></label>
            <input type="text" name="city"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group">
            <label>Mobile Number<span style="color:red;"> * </span></label>
            <input type="number" name="mobile_no"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>

          <div class="form-group">
            <label>Email <span style="color:red;"> * </span></label>
            <input type="email" name="email"
              style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black; border:1px solid grey;"
              required>
          </div>
        </form>
      </div>
      <div class="form-group text-right" style="margin-top:20px;">
        <button type="button" class="btn btn-lg btn-success" onclick="submitForm_edit()"> <i class="fas fa-check"></i> Submit
        </button>
      </div>
    </div>
  </div>
</div>
<!-- end dashboard inner -->