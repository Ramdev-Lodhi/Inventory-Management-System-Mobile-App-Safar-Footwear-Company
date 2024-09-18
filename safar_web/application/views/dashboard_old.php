<?php
// echo"<pre>";print_r($category_counts_second);
// die();
?>
<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Dashboard</title>
  <style>
    .tooltip {
      position: absolute;
      text-align: center;
      width: auto;
      padding: 8px;
      font: 12px sans-serif;
      background: lightsteelblue;
      border: 0;
      border-radius: 8px;
      pointer-events: none;
      opacity: 0;
    }
  </style>
</head>
<!-- Sidebar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->

<!-- topbar -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end topbar -->

<!-- dashboard inner -->

<?php
if (!empty($rawmaterial)) {
  echo '<script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                $("#rawMaterialModal").modal("show");
            });
          </script>';
}
?>
<div class="modal fade" id="rawMaterialModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Raw Material Alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      <i class="fas fa-exclamation-triangle fa-3x text-danger animate__animated animate__bounceIn"></i></i>
        <p class="mt-3">You have some less raw material in stock. To check click the button.</p>
      </div>
      <div class="modal-footer">

        <a href="<?= base_url('rawmaterial/less_rawmaterial') ?>" class="btn btn-primary">Go to Raw Material Manage</a>
      </div>
    </div>
  </div>
</div>
<!-- Page Content  -->
<div style="padding-top: 15px; ">
  <!-- <div class="white_shd full margin_bottom_30"> -->
  <div class="row column1">
    <div class="col-lg-2">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="heading1 margin_0">
            <h5 align="center">STOCK IN GODOWN(FIRST Quality) -
              <?php
              $count = 0;
              foreach ($category_counts_first as $cat_1) {
                $count += $cat_1['count']; // Access 'COUNT' key instead of 'count'
              }
              echo $count;
              ?>
            </h5>
          </div>
        </div>
        <!-- <div class="map_section padding_infor_info"> -->
        <canvas id="pie_chart"></canvas>
        <!-- </div> -->
      </div>
      <div class="modal" id="subChartModal" tabindex="-1">
        <div class="modal-dialog" style="max-width: 830px; margin: 1.75rem auto;">
          <div class="modal-content">
            <div class="d-flex justify-content-between ">
              <h4>STOCK IN GODOWN (FIRST Quality)</h4>
              <a class="btn btn-warning " href="<?php echo base_url('welcome'); ?>"> <i class="fas fa-angle-left"></i>
                Back</a>
            </div>
            <div class="modal-body">
              <div id="sub_doughnut_chart" style="padding-left:6%"></div>
              <div class="tooltip" id="tooltip"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- </div> -->
    </div>

    <div class="col-lg-2">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="heading1 margin_0">
            <h5 align="center">STOCK IN GODOWN(SECOND Quality) -
              <?php
              $count = 0;
              foreach ($category_counts_second as $cat_1) {
                $count += $cat_1['count']; // Access 'COUNT' key instead of 'count'
              }
              echo $count;
              ?>
            </h5>
          </div>
        </div>
        <!-- <div class="map_section padding_infor_info"> -->
        <canvas id="pie_chart_second"></canvas>
        <!-- </div> -->
      </div>
      <div class="modal" id="subChartModal_second" tabindex="-1">
        <div class="modal-dialog" style="max-width: 830px; margin: 1.75rem auto;">
          <div class="modal-content">
            <div class="d-flex justify-content-between ">
              <h4>STOCK IN GODOWN (SECOND Quality)</h4>
              <a class="btn btn-warning " href="<?php echo base_url('welcome'); ?>"> <i class="fas fa-angle-left"></i>
                Back</a>
            </div>
            <div class="modal-body">
              <div id="sub_doughnut_chart_second" style="padding-left:6%"></div>
              <div class="tooltip" id="tooltip"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- </div> -->
    </div>
    <div class="col-lg-2">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="heading1 margin_0">
            <h5 align="center">JOB SHEET & PAYMENT STATUS - &emsp;
              <?php
              $count = 0;
              foreach ($job as $j) {
                $count++;
              }
              echo $count;
              ?>
            </h5>
          </div>
        </div>

        <!-- <div class="map_section padding_infor_info"> -->
        <canvas id="pie_jobsheet"></canvas>
        <!-- </div> -->
      </div>
    </div>
  </div>
</div>
<!-- </div> -->

<?php $this->load->view('chart/view'); ?>
<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>