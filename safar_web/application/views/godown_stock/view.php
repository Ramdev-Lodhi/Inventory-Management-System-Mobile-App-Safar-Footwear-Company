
<head>
  <?php $this->load->view('includes/header'); ?>
  
</head>
  <div class="white_shd full margin_bottom_30">
    <div class="full graph_head">
      <div class="col-lg-12 my-2">
        <h2 class="text-center mb-3">View Details</h2>
      </div>
      <div class="d-flex justify-content-end ">
        <a class="btn btn-warning btn-lg" href="<?php echo base_url('godownstock'); ?>"> <i
            class="fas fa-angle-left"></i>
          Back</a>
      </div>
    </div>
    <div class="padding_infor_info">
        <div id="table-container" class="table-responsive">
          <table id="example" class="table table-bordered table-default table-hover"
            style="background-color:#FDF5E6;width:100%;">
            <thead class="thead-light">
              <tr>
                <th>Inward ID</th>
                <th>QR Id</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>