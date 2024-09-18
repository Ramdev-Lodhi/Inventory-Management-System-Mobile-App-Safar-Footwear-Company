<head>
  <?php $this->load->view('includes/header'); ?>
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
    $(document).ready(function () {
      $('#example').DataTable({
        // DataTables initialization options
      });
    });
  </script>
</head>
<div class="white_shd full margin_bottom_30">
  <div class="full graph_head">
    <div class="col-lg-12 my-2">
      <h2 class="text-center mb-3">View Details</h2>
    </div>
    <div class="d-flex justify-content-between ">
      <div> Qr-Code:<h5 id="qrcode"></h5></div>
      <a class="btn btn-warning btn-lg" href="<?php echo base_url('reader/status'); ?>"> <i
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
            <th  width="5%">ID</th>
            <th width="15%">Article Name</th>
            <th width="15%">Color</th>
            <th width="15%">Size</th>
            <th width="15%">Barcode</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>