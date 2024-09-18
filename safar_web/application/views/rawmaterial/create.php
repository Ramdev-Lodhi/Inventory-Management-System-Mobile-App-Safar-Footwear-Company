<div class="row column1">
    <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="col-lg-12 my-2">
                    <h2 class="text-center mb-3">Add New Raw Material</h2>
                </div>
                <div class="d-flex justify-content-end ">

                    <a class="btn btn-warning btn-lg" href="<?php echo base_url('rawmaterial'); ?>"> <i
                            class="fas fa-angle-left"></i>
                        Back</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="padding_infor_info">
                    <form method="post" action="<?php echo base_url('rawmaterial/store'); ?>">

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" required oninput="this.value=this.value.toUpperCase()" style="text-transform:uppercase"><br>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input class="form-control" type="number" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="threshold">Threshold:</label>
                            <input class="form-control" type="number" name="threshold" required>
                        </div>
                        <div class="form-group ">
                            <label>Unit</label>
                            <select name="unit" id="unit"
                                style="padding:10px 10px;width:100%;border-radius:10px;color:black;">
                                <option value="KG">KG</option>
                                <option value="pieces">Pieces</option>
                            
                            </select>
                        </div>
                        <div class="col-md-12 text-right" class="form-group">
                            <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-check"></i> Submit
                            </button>
                        </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
