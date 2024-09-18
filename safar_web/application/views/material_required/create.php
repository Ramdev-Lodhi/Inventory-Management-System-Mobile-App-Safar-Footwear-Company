<div class="row column1">
    <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="col-lg-12 my-2">
                    <h2 class="text-center mb-3">Add Material Required</h2>
                </div>
                <div class="d-flex justify-content-end ">

                    <a class="btn btn-warning btn-lg" href="<?php echo base_url('rawmaterial/material_required'); ?>">
                        <i class="fas fa-angle-left"></i>
                        Back</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="padding_infor_info">
                    <form method="post" action="<?php echo base_url('rawmaterial/material_required_store'); ?>">
                        <div class="form-group">
                            <label>Article</label>

                            <select name="article" id="article"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;"
                                onchange="get_color_by_articleId();" required>
                                <option>Select Article</option>
                                <?php foreach ($article as $a) { ?>
                                    <option value="<?= $a->id . "~" . $a->name ?>" ><?php foreach($category as $cat){ 
                    if($cat->id == $a->category){
                      echo $a->name."(".$cat->name.")";
                      }   } ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group first">
                            <label>Color</label>
                            <select name="color" id="color"
                                style="padding:10px 10px;width:100%;border-radius:10px;color:black;" required></select>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group">
                                    <label for="name">Polyurethane:</label>
                                    <input class="form-control" type="number" step="any" name="Polyurethane" >
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group">
                                    <label for="quantity">Isocyanates:</label>
                                    <input class="form-control" type="number" step="any" name="Isocyanates">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>Catalysts</label>
                                    <input class="form-control" type="number" step="any" name="Catalysts">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>Rising Chemical</label>
                                    <input class="form-control" type="number" step="any" name="rising_chemical">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>Skin Chemical</label>
                                    <input class="form-control" type="number" step="any" name="skin_chemical">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>Releasing Agent</label>
                                    <input class="form-control" type="number" step="any" name="releasing_agent">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>MCL</label>
                                    <input class="form-control" type="number" step="any" name="MCL">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>ELFI GLUE</label>
                                    <input class="form-control" type="number" step="any" name="ELFI_GLUE">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>PVC BAGS</label>
                                    <input class="form-control" type="number" step="any" name="PVC_BAGS">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>LIFTER</label>
                                    <input class="form-control" type="number" step="any" name="LIFTER">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>BUTTER PAPER</label>
                                    <input class="form-control" type="number" step="any" name="BUTTER_PAPER">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>LD BAGS</label>
                                    <input class="form-control" type="number" step="any" name="LD_BAGS">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>OUTTER LABEL</label>
                                    <input class="form-control" type="number" step="any" name="OUTTER_LABEL">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>INNER LABEL</label>
                                    <input class="form-control" type="number" step="any" name="INNER_LABEL">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-group ">
                                    <label>REXINE</label>
                                    <input class="form-control" type="number" step="any" name="REXINE">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-right" class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i>
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>