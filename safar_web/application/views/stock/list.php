<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <!-- DATATABLES CSS -->

    <style type="text/css">
        .dt-button {
            border-radius: 10px;
            border: none;
            color: white;
            background-color: #494ca2;
            padding: 5px 10px;
        }

        input {
            border-radius: 10px;
            border: 1px solid black;
            padding: 2px 5px;

        }

        label {
            color: black;
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
            font-family: sans-serif;
            /* font-size: 16px; */
        }
    </style>

    <!-- JS for DataTables -->
    <script type="text/javascript">
        window.onload = function exampleFunction() {
            new DataTable('#example', {
                layout: {
                    top: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                },
                pagingType: 'simple_numbers',
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

    <div class="midde_cont">
      
                <div class="row column1">
                    <div class="col-md-12" style="padding:5px;">
                        <div class="white_shd full margin_bottom_30">
                            <div class="full graph_head">
                                <?php echo $this->session->flashdata('message'); ?>
                                <a href="<?= base_url('stock/update_records') ?>" class="btn btn-primary"
                                    style="margin-bottom:20px;">Update
                                    Records</a>
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Article Name</th>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Pairs in <?= $godown[0]->name ?></th>
                                                <th>Pairs in <?= $godown[1]->name ?></th>
                                                <th>Total Stock (in pairs)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($data as $d) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $d['name'] ?></td>
                                                    <td><?= $d['color'] ?></td>
                                                    <td style="text-align:center;"><?= $d['size'] ?></td>
                                                    <td style="text-align:center;"><?= $d['pairs_in_g1'] ?></td>
                                                    <td style="text-align:center;"><?= $d['pairs_in_g2'] ?></td>
                                                    <td style="text-align:center;">
                                                        <?= $d['pairs_in_g1'] + $d['pairs_in_g2'] ?>
                                                    </td>
                                                </tr><?php $i++;
                                            }
                                            ?>
                                            <!-- <tfoot>
                         <tr>
                             <th>#</th>
                             <th>Article Name</th>
                             <th>Color</th>
                             <th>Size</th>
                             <th>Pairs in <?php echo "Godwon name" ?></th>
                             <th>Pairs in <?php echo "Godwon name" ?></th>
                             <th>Total Stock (in pairs)</th>
                         </tr>
                         </tfoot> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
       


<?php $this->load->view('includes/footer'); ?>