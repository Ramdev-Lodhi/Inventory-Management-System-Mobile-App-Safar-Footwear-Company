<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Raw Material</title>
  <script src="https://cdn.jsdelivr.net/npm/raphael@2.3.0/raphael.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/justgage@1.3.5/justgage.min.js"></script>
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
  <!-- <script type="text/javascript">
    window.onload = function exampleFunction() {
      var table = new DataTable('#example','#my', {
        layout: {

          //bottom: {buttons: ['colvis','copyHtml5','csvHtml5','excelHtml5','pdfHtml5','print']}
        },
        // paging: false,
        // scrollCollapse: true,
        // scrollY: '50vh'
      });
    } -->
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
              <h4>LIST OF RAW MATERIAL 1</h4>
            </div>
            <table id="example" class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">

              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">Raw Material</th>
                  <th width="10%">Quantity</th>
                  <th width="10%">Threshold</th>
                  <th width="12%">Status</th>
                  <th width="15%">Supplier Name </th>
                  <th width="5%">Actions</th>
                </tr>
              <tbody>
                <?php $i = 1;
                foreach ($less_rawmaterial1 as $key => $material): ?>

                  <tr align="center">


                    <td><?php echo $i; ?></td>


                    <td><?php echo $material['name']; ?></td>
                    <td><?php echo $material['quantity']; ?></td>
                    <td><?php echo $material['threshold']; ?></td>
                    <td>
                      <div id="gaugeContainer_<?= $key ?>" style="width:90%"></div>
                    </td>
                    <form action="<?= base_url('rawmaterial/send_email') ?>" method="POST">
                      <td>
                        <?php
                        foreach ($supplier1 as $s_one) {
                          if ($s_one->rawmaterial_id == $material['id']) {
                            echo '<label style="display: inline-block; margin-right: 10px;"><input type="checkbox" name="suppliers[]" value="' . $s_one->email . '" class="supplier-checkbox"> ' . $s_one->name . '</label>';
                          }
                        }

                        // foreach ($supplier2 as $s_two) {
                        //   if ($s_two->rawmaterial_id == $material['id']) {
                        //     echo '<label style="display: inline-block; margin-right: 10px;"><input type="checkbox" name="suppliers[]" value="' . $s_two->email . '" class="supplier-checkbox"> ' . $s_two->name . '</label>';
                        //   }
                        // }
                        ?>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-lg btn-info"><i class="fas fa-send"></i> Send Email</button>
                      </td>
                    </form>


                  </tr>
                  <script>
                    var g<?= $key ?> = new JustGage({
                      id: "gaugeContainer_<?= $key ?>",
                      value: <?= $material['quantity']/100 ?>,
                      min: 0,
                      // max: <?// $material['threshold']?>,
                      max: 100,
                      title: "Status",
                      label: "%",
                      gaugeWidthScale: 0.6,
                      counter: true,
                      pointer: true,
                      relativeGaugeSize: true,
                      customSectors: {
                        ranges: [{
                          color: "#FF0000",
                          lo: 0,
                          hi: <?= $material['threshold'] ?>
                        }, {
                          color: "#00FF00",
                          lo: <?= $material['threshold'] ?>,
                          hi: 100
                        }]
                      }
                    });
                  </script>
                  <?php $i++;
                endforeach; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="row column2">
    <div class="col-md-12" style="padding:20px;">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="table-responsive">

            <div class="d-flex justify-content-between mb-3">
              <h4>LIST OF RAW MATERIAL 2</h4>
            </div>
            <table id="example" class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">

              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">Raw Material</th>
                  <th width="10%">Quantity</th>
                  <th width="10%">Threshold</th>
                  <th width="12%">Status</th>
                  <th width="15%">Supplier Name </th>
                  <th width="5%">Actions</th>
                </tr>
              <tbody>
                <?php $i = 1;
                foreach ($less_rawmaterial2 as $key => $material): ?>

                  <tr align="center">


                    <td><?php echo $i; ?></td>


                    <td><?php echo $material['name']; ?></td>
                    <td><?php echo $material['quantity']; ?></td>
                    <td><?php echo $material['threshold']; ?></td>
                    <td>
                      <div id="gaugeContainers_<?= $key ?>" style="width:90%"></div>
                    </td>
                    <form action="<?= base_url('rawmaterial/send_email') ?>" method="POST">
                      <td>
                        <?php

                        foreach ($supplier2 as $s_two) {
                          if ($s_two->rawmaterial_id == $material['id']) {
                            echo '<label style="display: inline-block; margin-right: 10px;"><input type="checkbox" name="suppliers[]" value="' . $s_two->email . '" class="supplier-checkbox"> ' . $s_two->name . '</label>';
                          }
                        }
                        ?>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-lg btn-info"><i class="fas fa-send"></i> Send Email</button>
                      </td>
                    </form>


                  </tr>
                  <script>
                    var g<?= $key ?> = new JustGage({
                      id: "gaugeContainers_<?= $key ?>",
                      value: <?= $material['quantity']/100 ?>,
                      min: 0,
                      // max: <? //$material['threshold']?>,
                      max: 100,
                      title: "Status",
                      label: "%",
                      gaugeWidthScale: 0.6,
                      counter: true,
                      pointer: true,
                      relativeGaugeSize: true,
                      customSectors: {
                        ranges: [{
                          color: "#FF0000",
                          lo: 0,
                          hi: <?= $material['threshold'] ?>
                        }, {
                          color: "#00FF00",
                          lo: <?= $material['threshold'] ?>,
                          hi: 100
                        }]
                      }
                    });
                  </script>
                  <?php $i++;
                endforeach; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>