<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Article</title>
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
                responsive: true

            },

        });
    }
    </script>
</head>
<!-- Sidebar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->

<!-- topbar -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end topbar -->

<!-- dashboard inner -->
<div class="midde_cont">

    <div class="row column1">
        <div class="col-md-12" style="padding:5px;">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between mb-3">

                            <h4> LIST OF ALL ARTICLE IN MASTER TABLES </h4>

                            <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#addarticle"><i
                                    class="fas fa-plus"></i>
                                Add
                                New Article</a>
                        </div>
                        <table id="example" class="table table-bordered table-default table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th width="2%">#</th>
                                    <th width="10%">Article Photo</th>
                                    <th width="10%">Article Name</th>
                                    <th width="5%">Type</th>
                                    <th width="5%">Category</th>
                                    <th width="8%">MRP</th>
                                    <th width="5%">Package</th>
                                    <th width="8%">No. of Pairs</th>
                                    <th width="5%">Is Active</th>
                                    <th width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                  foreach ($data as $article) { ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <div class="article-image">
                                            <?php if (!empty($article->photo)) { ?><img
                                                src="<?= base_url($article->photo); ?>" alt="article-image"><?php } ?>
                                        </div>
                                    </td>
                                    <td><?php echo $article->name; ?></td>
                                    <td><?php echo $article->type; ?></td>
                                    <td><?php echo $article->category; ?></td>
                                    <td><?php echo $article->mrp; ?></td>
                                    <td><?php echo $article->package; ?></td>
                                    <td><?php echo $article->no_of_pairs; ?></td>
                                    <td><?php echo $article->is_active; ?></td>
                                    <td>

                                        <a href="#" class="btn btn-primary"
                                            onclick="editarticle(<?php echo $article->id ?>)" data-toggle="modal"
                                            data-target="#editarticle"> <i class="fas fa-edit"></i> Edit </a>
                                        <a href="<?= base_url('article/delete/' . $article->id) ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this record?')"> <i
                                                class="fas fa-trash"></i>
                                            Delete </a>
                                    </td>

                                </tr>
                                <?php $i++;
                  } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- end dashboard inner -->


<!-- add article -->
<div class="modal fade" tabindex="-1" role="dialog" id="addarticle">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('article/create'); ?>
        </div>
    </div>
</div>
<!-- end add article -->

<!-- start edit article -->
<div class="modal fade" tabindex="-1" role="dialog" id="editarticle">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('article/edit') ?>
        </div>
    </div>
</div>
<!-- end edit article -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>



<?php $this->load->view('article/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>