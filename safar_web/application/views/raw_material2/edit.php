<div class="row column1">
    <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="col-lg-12 my-2">
                    <h2 class="text-center mb-3">Add New </h2>
                </div>
                <div class="d-flex justify-content-end ">

                    <a class="btn btn-warning btn-lg" href="<?php echo base_url('rawmaterial/raw_material2'); ?>"> <i
                            class="fas fa-angle-left"></i>
                        Back</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="padding_infor_info">
                    <form method="post" action="<?php echo base_url('rawmaterial/raw_material2_update'); ?>"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" required
                                oninput="this.value=this.value.toUpperCase()" style="text-transform:uppercase"><br>
                        </div>
                        <div class="form-group">
                            <label>Sub Name:</label>
                            <input class="form-control" type="text" name="sub_name">
                        </div>
                        <!-- <div class="form-group">
                            <label>Category:</label>
                            <input class="form-control" type="text" name="category">
                        </div> -->
                        <div class="form-group">
                            <label>Category Id</label>&nbsp &nbsp
                            <select class="form-select" name="category">
                                <?php foreach ($category as $c) { ?>
                                    <option value="<?= $c->name ?>"><?= $c->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Color:</label>
                            <input class="form-control" type="text" name="color" oninput="this.value=this.value.toUpperCase()" style="text-transform:uppercase">
                        </div>
                        <div class="form-group">
                            <label>Design:</label>
                            <input class="form-control" type="text" name="design">
                        </div>
                        <div class="form-group">
                            <label>Size:</label>
                            <input class="form-control" type="text" name="size">
                        </div>
                        <div class="form-group">
                            <label>Thickness:</label>
                            <input class="form-control" type="text" name="thickness">
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <div class="d-flex justify-content-between">
                                <div class="article-image">
                                    <img id="image" src="" alt="Updated Image">
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
                                                <span class="drop-zone-text">Drop file here or click to upload and
                                                    Change Photo</span>
                                                <input class="form-control" type="hidden" name="photo">
                                                <input type="file" name="product-image[]" class="drop-zone-input"
                                                    id="drop-zone-input-1" onchange="previewImage1(this.files)">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input class="form-control" type="number" name="quantity">
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit:</label>
                            <input class="form-control" type="text" name="unit">
                        </div>
                        <div class="form-group">
                            <label for="threshold">Threshold:</label>
                            <input class="form-control" type="number" name="threshold">
                        </div>
                        <!-- <div class="form-group ">
                            <label>Unit</label>
                            <select name="unit" id="unit"
                                style="padding:10px 10px;width:100%;border-radius:10px;color:black;">
                                <option value="KG">KG</option>
                                <option value="pieces">Pieces</option>
                            
                            </select>
                        </div> -->
                        <div class="col-md-12 text-right" class="form-group">
                            <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-check"></i>
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>