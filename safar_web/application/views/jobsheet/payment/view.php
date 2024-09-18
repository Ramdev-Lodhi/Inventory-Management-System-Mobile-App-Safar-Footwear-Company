<div class="row column1">
    <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="col-lg-12 my-2">
                    <h2 class="text-center mb-3">Jobsheet Payment Details</h2>
                </div>
                <div class="d-flex justify-content-end ">

                    <a class="btn btn-warning btn-lg" href="<?php echo base_url('jobsheet/payment'); ?>"> <i
                            class="fas fa-angle-left"></i>
                        Back</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="padding_infor_info">
                    <form method="post" action="<?php echo base_url('jobsheet/change_payment_status'); ?>">
                        <div class="form-group first">
                            <label>Job Type</label>
                            <input class="form-control" type="text" readonly name="job_type">
                        </div>
                        <div class="form-group first">
                            <label>Contractor Name</label>
                            <input class="form-control" type="text" readonly name="contractor">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Size</label>
                                    <input class="form-control" type="text" readonly name="size">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Color</label>
                                    <input class="form-control" type="text" readonly name="color">
                                </div>
                            </div>
                        </div>

                        <div class="form-group first">
                            <label>No. of Pairs </label>
                            <input class="form-control" type="text" readonly name="no_of_pairs">
                        </div>
                        <div class="form-group first">
                            <label>Total Amount</label>
                            <input class="form-control" type="text" readonly name="amount">
                        </div>
                        <div class="form-group first">
                            <label>Payment Time</label>
                            <input class="form-control" type="date" name="date" required>
                        </div>

                        <div class="form-group" style="font-weight:bold;">
                            <label for="">Payment Done</label>
                            <div>
                                <label for="payment_first" style="margin-right:10px">Yes</label>
                                <input type="radio" name="payment" id="payment_first" value="1">

                                <label for="payment_second" style="margin-left:20px;margin-right:10px">No</label>
                                <input type="radio" name="payment" id="payment_second" value="0" >
                            </div>
                        </div>


                        <div class="col-md-12 text-right" class="form-group">
                            <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-check"></i> Change
                                Status
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