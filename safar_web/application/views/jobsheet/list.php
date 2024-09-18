<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Job Sheet</title>
</head>
<style>
    form label {
        font-weight: bold
    }
</style>
<!-- siderbar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->
<!-- top header -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end top header -->


<div style="padding-top:5px;">
    <!-- dashboard inner -->
    <div class="midde_cont">
        <div class="row column1">
            <div class="col-md-12">
                <?php echo $this->session->flashdata('message'); ?>
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">



                        <div class="table-responsive">
                            <div class="d-flex justify-content-end mb-3">

                                <!-- <a href="<?= base_url('jobsheet/delete_all_jobsheet') ?>" class="btn btn-lg btn-danger">
                                    Delete
                                    All Job Sheets
                                </a> -->

                                <a href="#" class="btn btn-lg btn-success" data-toggle="modal"
                                    data-target="#addjobsheet"><i class="fas fa-plus"></i>
                                    Add New Job Sheet</a>
                            </div>

                            <table class="table table-bordered table-default">

                                <thead class="thead-light">
                                    <tr align="center">
                                        <th width="2%">#</th>
                                        <th width="15%">Article</th>
                                        <th width="15%">Color</th>
                                        <th width="15%">No. of Pairs</th>
                                        <th width="10%">Size</th>
                                        <th width="10%">Contractor</th>
                                        <th width="10%">Date</th>
                                        <th width="33%">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php $i = 1;
                                    foreach ($data as $l) { ?>

                                        <tr align="center">


                                            <td><?php echo $i; ?></td>
                                            <td><?php foreach ($article as $ar) {
                                                if ($ar->id == $l->article_id) {
                                                    echo $ar->name;
                                                }
                                            } ?></td>
                                            <td><?php foreach ($color as $c) {
                                                if ($c->id == $l->color_id) {
                                                    echo $c->color;
                                                }
                                            } ?></td>

                                            <td><?php echo $l->no_of_pairs; ?></td>
                                            <td><?php echo $l->size; ?></td>
                                            <td><?php foreach ($contractor as $con) {
                                                if ($con->id == $l->contractor_name) {
                                                    echo $con->contractor_name;
                                                }
                                            } ?></td>
                                            <td><?php echo $l->issue_date; ?></td>
                                            <td>

                                                <a href="#" data-toggle="modal" data-id="<?php echo $l->id; ?>"
                                                    data-target="#editjobsheet"  class="btn btn-lg btn-info edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>


                                                <a href="<?= base_url('jobsheet/delete/' . $l->id) ?>"
                                                    class="btn btn-lg btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <i class="fas fa-trash"></i> Delete </a>
                                                <a href="<?= base_url('jobsheet/generate_jobsheet/' . $l->id) ?>"
                                                    class="btn btn-lg btn-primary">
                                                    QR-Print</a>
                                                

                                            </td>
                                        </tr>

                                        <?php $i++;
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end dashboard inner -->
</div>
<!-- create lable -->
<div class="modal fade" tabindex="-1" role="dialog" id="addjobsheet">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('jobsheet/create'); ?>
        </div>
    </div>
</div>
<!-- end create lable -->

<!-- edit lable -->
<div class="modal fade" tabindex="-1" role="dialog" id="editjobsheet">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">

            <?php $this->load->view('jobsheet/edit'); ?>

        </div>
    </div>
</div>
<!-- end edit lable -->

<?php $this->load->view('jobsheet/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>