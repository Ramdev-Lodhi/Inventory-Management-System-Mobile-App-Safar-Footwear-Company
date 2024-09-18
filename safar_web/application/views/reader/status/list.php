<?php
// echo "<pre>";
// print_r($status);
// die(); ?>
<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Status</title>
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
            text-align: center;
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
        <div class="col-md-12" style="padding:5px;">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <h3>Status</h3>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-default table-hover"
                            style="background-color:#FDF5E6;width:100%;">

                            <thead class="thead-light">
                                <tr>
                                    <th style="text-align:center" width="2%">#</th>
                                    <th style="text-align:center" width="15%">QR Code</th>
                                    <th style="text-align:center" width="15%">Time</th>
                                    <th style="text-align:center" width="15%">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody >

                                <?php
                                $i = 1;
                                // print_r($status);
                                // die();
                                foreach ($data as $reader) { ?>
                                    <tr>
                                        <td style="text-align:center"><?= $i ?> </td>
                                        <td style="text-align:center"><?= $reader['qrcode'] ?></td>
                                        <td style="text-align:center"><?= $reader['timestamp'] ?></td>

                                        <td style="text-align:center"> <a href="#" class="btn  btn-success  details "
                                                data-id="<?= $reader['qrcode']; ?>" data-toggle="modal"
                                                data-target="#readerdetails"><i class="fas fa-eye"></i> Details
                                            </a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end dashboard inner -->

<!-- detials -->
<div class="modal fade" tabindex="-1" role="dialog" id="readerdetails">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('reader/status/view'); ?>
        </div>
    </div>
</div>
<!-- end detials-->

<?php $this->load->view('reader/status/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>