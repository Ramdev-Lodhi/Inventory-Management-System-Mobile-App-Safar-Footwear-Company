<div class="row column1">
    <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="col-lg-12 my-2">
                    <h2 class="text-center mb-3">Edit Job Sheet</h2>
                </div>
                <div class="d-flex justify-content-end ">

                    <a class="btn btn-warning btn-lg" href="<?php echo base_url('jobsheet'); ?>"> <i
                            class="fas fa-angle-left"></i>
                        Back</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="padding_infor_info">
                    <form method="post" action="<?php echo base_url('jobsheet/update'); ?>">
                        <div class="form-group first">
                            <label>Job Type</label>
                            <select name="job_type" id="job_type"
                                style="padding:10px 10px;width:100%;border-radius:10px;color:black;">
                                <option value="BOTH">BOTH</option>
                                <option value="UPPER">UPPER</option>
                                <option value="SOLE">SOLE</option>

                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label>Job Type</label>

                            <select name="job_type" id="job_type_id"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;">
                                <?php //foreach ($job_type as $job) { ?>
                                    <option value="<? //$job->job_type_id ?>"><? //$job->type_name ?></option>
                                <?php //} ?>
                            </select>

                        </div> -->
                        <div class="form-group">
                            <label>Article</label>

                            <select name="article" id="article"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;"
                                onchange="get_size_by_articleId();get_color_by_articleId();get_no_of_pairs_by_articleId();">
                                <option>Select Article</option>
                                <?php foreach ($article as $a) { ?>
                                    <option value="<?= $a->id ?>"><?php 
                                    foreach($category as $cat){
                                        if($cat->id == $a->category) {
                                            echo  $a->name ."(". $cat->name .")";
                                    }
                                }
                                          ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group first">
                            <label>Size</label>
                            <select name="size" id="size_edit"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;"></select>
                        </div>

                        <div class="form-group first">
                            <label>Color</label>
                            <select name="color" id="color_edit"
                                style="padding:10px 10px;width:100%;border-radius:10px;color:black;"></select>
                        </div>

                        <!-- <div class="form-group first">
              <label>Number of Pairs</label>
              <select name="no_of_pairs" id="no_of_pairs"
                style="padding:10px 10px;width:100%;border-radius:10px;color:black;">
                <option value="30">30</option>
                <option value="48">48</option>
                <option value="60">60</option>
                <option value="96">96</option>
                <option value="108">108</option>
                <option value="180">180</option>
              </select>
            </div> -->
                        <div class="form-group">
                            <label>Number of Pairs</label>
                            <input class="form-control" type="text" name="no_of_pairs">
                        </div>
                        <div class="form-group">
                            <label>Contractor</label>

                            <select name="contractor" id="contractor"
                                style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;">
                                <option value="">Select Contractor</option>
                                <?php foreach ($contractor as $con) { ?>
                                    <option value="<?= $con->id ?>"><?= $con->contractor_name ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <!-- <div class="form-group">
                            <label>Issue Date</label>
                            <input class="form-control" type="date" name="date">
                        </div> -->



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

<!-- end dashboard inner -->
<!-- <?php //$this->load->view('includes/footer'); ?> -->