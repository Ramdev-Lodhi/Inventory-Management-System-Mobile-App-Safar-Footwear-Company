<?php
// echo "<pre>";
// print_r($status);
// die(); ?>
<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Jobsheet Status</title>
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
                    <h3> Job Sheet Status</h3>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-default table-hover"
                            style="background-color:#FDF5E6;width:100%;">

                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2" width="2%">#</th>
                                    <th rowspan="2" width="15%">Job Sheet-ID</th>
                                    <th rowspan="2" width="15%">Job Type</th>
                                    <?php for ($m = 1; $m < count($dept); $m++) { ?>
                                        <th rowspan="2"width="15%"> <?= $dept[$m]->dept_name ?></th>
                                    <?php } ?>
                                    <th colspan="2">Action</th>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>

                            <tbody>

                                <?php
                                $i = 1;
                                // print_r($status);
                                // die();
                                foreach ($status as $st) { ?>
                                    <tr>
                                        <td><?= $i ?> </td>
                                        <td><?= $st['jobsheet_id'] ?> </td>
                                        <td><?= $st['job_type'] ?></td>
                                        <?php
                                        for ($k = 1; $k < count($st['departments']); $k++) {
                                            echo '<td>';
                                            if ($st['departments'][$k]['status'] === 'success') {
                                                echo '<span style="color:green">Dispatched</span>';
                                            } elseif ($st['departments'][$k]['status'] === 'pending') {
                                                echo '<span style="color:red">In Process</span>';
                                            } else {
                                                echo '-';
                                            }
                                            echo '</td>';
                                        }
                                        ?>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" <?php if($st['job_status']==1){echo "checked";}?> role="switch"
                                                    id="<?= $st['jobsheet_id'];?>" onchange="status(this.id)" >
                                            </div>
                                        </td>
                                        <td> <a href="#" class="btn  btn-success float-right details "
                                                data-id="<?php echo $st['jobsheet_id']; ?>" data-toggle="modal"
                                                data-target="#viewdetails"><i class="fas fa-eye"></i> Details
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

<!-- add category -->
<div class="modal fade" tabindex="-1" role="dialog" id="viewdetails">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('jobsheet/status/view'); ?>
        </div>
    </div>
</div>
<!-- end add category -->

<?php $this->load->view('jobsheet/status/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>