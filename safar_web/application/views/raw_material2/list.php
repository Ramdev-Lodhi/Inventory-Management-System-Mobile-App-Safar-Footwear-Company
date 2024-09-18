<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Raw Material</title>
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
    </style>
    <!-- JS for DataTables -->
    <script type="text/javascript">
        window.onload = function exampleFunction() {
            var table = new DataTable('#example', {
                layout: {

                    //bottom: {buttons: ['colvis','copyHtml5','csvHtml5','excelHtml5','pdfHtml5','print']}
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

<!-- Page Content  -->

<!-- dashboard inner -->
<div class="midde_cont">
    <div class="row column1">
        <div class="col-md-12" style="padding:20px;">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="table-responsive">

                        <div class="d-flex justify-content-between mb-3">
                            <h4>LIST OF RAW MATERIAL</h4>
                            <a href="#" class="btn btn-success float-right" data-toggle="modal"
                                data-target="#addrawmaterial_sub"> <i class="fas fa-plus"></i> Add New </a>
                        </div>
                        <table id="example" class="table table-bordered table-default table-hover"
                            style="background-color:#FDF5E6;width:100%;">

                            <thead class="thead-light">
                                <tr>
                                    <th width="2%">#</th>
                                    <th width="5%">Name</th>
                                    <th width="5%">SUb Name</th>
                                    <th width="5%">Category</th>
                                    <th width="5%">Color</th>
                                    <th width="5%">Design</th>
                                    <th width="5%">Size</th>
                                    <th width="5%">Thickness</th>
                                    <th width="10%">Photo</th>
                                    <th width="10%">Quantity</th>
                                    <th width="5%">Unit</th>
                                    <th width="5%">Threshold</th>
                                    <th width="20%">Last Modified on</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            <tbody>
                                <?php $i = 1;
                                foreach ($data as $material) { ?>

                                    <tr align="center">


                                        <td><?php echo $i; ?></td>


                                        <td><?php echo $material->name; ?></td>
                                        <td><?php echo $material->sub_name; ?></td>
                                        <td><?php echo $material->category; ?></td>
                                        <td><?php echo $material->color; ?></td>
                                        <td><?php echo $material->design; ?></td>
                                        <td><?php echo $material->size; ?></td>
                                        <td><?php echo $material->thickness; ?></td>
                                        <td>
                                            <div class="article-image">
                                                <?php if (!empty($material->photo)) { ?><img
                                                        src="<?= base_url($material->photo); ?>" alt="article-image"><?php } ?>
                                            </div>
                                        </td>
                                        <td><?php echo $material->quantity; ?></td>
                                        <td><?php echo $material->unit; ?></td>
                                        <td><?php echo $material->threshold; ?></td>
                                        <td><?php echo $material->modified_on; ?></td>

                                        <td>
                                            <a href="#" data-toggle="modal" data-id="<?php echo $material->id; ?>"
                                                data-target="#edit_raw_material2" class="btn btn-lg btn-info edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('rawmaterial/raw_material2_delete/' . $material->id) ?>"
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
<!-- add rawmaterial -->
<div class="modal fade" tabindex="-1" role="dialog" id="addrawmaterial_sub">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('raw_material2/create'); ?>
        </div>
    </div>
</div>
<!-- end add rawmaterial -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit_raw_material2">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('raw_material2/edit'); ?>
        </div>
    </div>
</div>
<?php $this->load->view('raw_material2/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>