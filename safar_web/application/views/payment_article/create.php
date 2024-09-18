
    <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_20">
            <div class="full graph_head">
                <div class="col-lg-12 my-2">
                    </div>
                    <div class="d-flex justify-content-between ">
                    <h2 class="text-center mb-3">Add New Payment Per Article</h2>

                    <a class="btn btn-warning btn-lg" href="<?php echo base_url('payment_article'); ?>"> <i
                            class="fas fa-angle-left"></i>
                        Back</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="padding_infor_info" style="padding:15px;">
                    <form method="post" action="<?php echo base_url('payment_article/store'); ?>">

                        <div class="form-group">
                            <label>Article</label>

                            <select name="article" id="article"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;"
                                onchange="get_size_by_articleId();get_color_by_articleId();">
                                <option>Select Article</option>
                                <?php foreach ($article as $a) { ?>
                                    <option value="<?= $a->id . "~" . $a->name ?>"><?php foreach($category as $cat){ 
                    if($cat->id == $a->category){
                      echo $a->name."(".$cat->name.")";
                      }   } ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="form-group first">
                            <label>Size</label>
                            <select name="size" id="size"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;"></select>
                        </div>

                        <div class="form-group first">
                            <label>Color</label>
                            <select name="color" id="color"
                                style="padding:10px 10px;width:100%;border-radius:10px;color:black;"></select>
                        </div>
                        <div class="form-group">
                            <label>Contractor</label>

                            <select name="contractor" id="contractor"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;">
                                <option value="">Select Contractor</option>
                                <?php foreach ($contractor as $contract) { ?>
                                    <option value="<?= $contract->id . '~' . $contract->contractor_name ?>">
                                        <?= $contract->contractor_name ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Store</label>
                                    <input class="form-control" type="number" step="any" name="store">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Cutting</label>
                                    <input class="form-control" type="number" step="any" name="cutting">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Printing</label>
                                    <input class="form-control" type="number" step="any" name="printing">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Embossing</label>
                                    <input class="form-control" type="number" step="any" name="embossing">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Stiching</label>
                                    <input class="form-control" type="number" step="any" name="stiching">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Pioring</label>
                                    <input class="form-control" type="number" step="any" name="pioring">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Production</label>
                                    <input class="form-control" type="number" step="any" name="production">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Trimming</label>
                                    <input class="form-control" type="number" step="any" name="trimming">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Sorting</label>
                                    <input class="form-control" type="number" step="any" name="sorting">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Packazing</label>
                                    <input class="form-control" type="number" step="any" name="packazing">
                                </div>
                            </div>
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
