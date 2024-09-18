<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Payment Per Article</title>
    <style type="text/css">
        .dt-button {
            border-radius: 10px;
            border: none;
            color: white;
            background-color: #644734;
            padding: 5px 10px;
        }

        input {
            border-radius: 10px;
            border: 1px solid black;
            padding: 2px 5px;

        }

        .dt-search {
            margin-bottom: 10px;
        }

        .dt-paging-button {
            padding: 0px 15px;
            margin: 2px;
            border-radius: 10px;
            border: 1px solid black;
            font-size: 18px;
        }

        table.table.dataTable> :not(caption)>*>* {
            /* background-color: #FDF5E6; */
            text-align: center;
        }

        table.dataTable td.dt-type-numeric,
        table.dataTable td.dt-type-date {
            text-align: center;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dc3545;
        }

        form label {
            font-weight: bold
        }
    </style>
    <!-- JS for DataTables -->
    <script type="text/javascript">
        window.onload = function exampleFunction() {
            var table = new DataTable('#example', {
                layout: {

                    // bottom: {buttons: ['colvis','copyHtml5','csvHtml5','excelHtml5','pdfHtml5','print']}
                },
                // paging: false,
                // scrollCollapse: true,
                // scrollY: '50vh'
            });
        }
    </script>
</head>
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
                                    data-target="#addpayment"><i class="fas fa-plus"></i>
                                    Add Payment</a>
                            </div>

                            <table id="example" class="table table-bordered table-default table-hover"
                                style="background-color:#FDF5E6;width:100%;">

                                <thead class="thead-light">
                                    <tr align="center">
                                        <th width="2%">#</th>
                                        <th width="10%">Article</th>
                                        <th width="10%">Contractor Name</th>
                                        <th width="8%">Color</th>
                                        <th width="8%">Size</th>
                                        <?php for ($m = 1; $m < count($dept); $m++) { ?>
                                            <th width="8%"> <?= $dept[$m]->dept_name ?></th>
                                        <?php } ?>
                                        <th width="20%">Total</th>
                                        <th width="20%">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php $i = 1;

                                    foreach ($data as $l) { ?>

                                        <tr align="center">


                                            <td><?php echo $i; ?></td>
                                            <td><?php foreach ($article as $ar) {
                                                if ($ar->id == $l->a_id) {
                                                    echo $ar->name;
                                                }
                                            } ?></td>
                                            <td><?php foreach ($contractor as $con) {
                                                if ($con->id == $l->contractor_name) {
                                                    echo $con->contractor_name;
                                                }
                                            } ?></td>
                                            <td><?php foreach ($color as $c) {
                                                if ($c->id == $l->a_color) {
                                                    echo $c->color;
                                                }
                                            } ?></td>

                                            <td><?php echo $l->size; ?></td>
                                            <td class="value"><?php echo $l->Store; ?></td>
                                            <td class="value"><?php echo $l->Cutting; ?></td>
                                            <td class="value"><?php echo $l->Printing; ?></td>
                                            <td class="value"><?php echo $l->Embossing; ?></td>
                                            <td class="value"><?php echo $l->Stiching; ?></td>
                                            <td class="value"><?php echo $l->Pioring; ?></td>
                                            <td class="value"><?php echo $l->Production; ?></td>
                                            <td class="value"><?php echo $l->Trimming; ?></td>
                                            <td class="value"><?php echo $l->Sorting; ?></td>
                                            <td class="value"><?php echo $l->Packazing; ?></td>
                                            <td class="total"></td>
                                            <td>

                                                <a href="#" data-toggle="modal" data-id="<?php echo $l->id; ?>"
                                                    data-target="#editpayment" class="btn btn-lg btn-info edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>


                                                <a href="<?= base_url('payment_article/delete/' . $l->id) ?>"
                                                    class="btn btn-lg btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this record?')">
                                                    <i class="fas fa-trash"></i> Delete </a>

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
<div class="modal fade" tabindex="-1" role="dialog" id="addpayment">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('payment_article/create'); ?>
        </div>
    </div>
</div>
<!-- end create lable -->

<!-- edit lable -->
<div class="modal fade" tabindex="-1" role="dialog" id="editpayment">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">

            <?php $this->load->view('payment_article/edit'); ?>

        </div>
    </div>
</div>
<!-- end edit lable -->


<?php $this->load->view('payment_article/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>