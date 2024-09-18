<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Supplier</title>
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
    <div class="col-md-12" style="padding:5px;">
      <?php echo $this->session->flashdata('message'); ?>
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="table-responsive">

            <div class="d-flex justify-content-between mb-3">
              <h4>LIST OF SUPPLIER 1</h4>
              <a href="#" class="btn btn-lg btn-success float-right" onclick="change()" data-toggle="modal"
                data-target="#addsupplier"> <i class="fas fa-plus"></i> Add New Category </a>
            </div>
            <table  class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">

              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">Raw Material</th>
                  <th width="15%">Category</th>
                  <th width="15%">Name</th>
                  <th width="15%">Address</th>
                  <th width="15%">City</th>
                  <th width="15%">Mobile Number</th>
                  <th width="15%">Email</th>
                  <th width="15%">Actions</th>
                </tr>

              <tbody>

                <?php $i = 1;

                foreach ($supplier_details1 as $supplier ) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php if($supplier->supplier=="first"){
                    foreach ($raw_material1 as $raw_id) {
                      if ($raw_id->id == $supplier->rawmaterial_id) {
                        echo $raw_id->name;
                      }
                    }}else{
                      foreach ($raw_material2 as $raw_id) {
                        if ($raw_id->id == $supplier->rawmaterial_id) {
                          echo $raw_id->name;
                        }
                      }
                    } ?></td>
                    <td><?php foreach ($category as $cat) {
                      if ($cat->id == $supplier->category_id) {
                        echo $cat->name;
                      }
                    } ?></td>
                    <td><?php echo $supplier->name; ?></td>
                    <td><?php echo $supplier->address; ?></td>
                    <td><?php echo $supplier->city; ?></td>
                    <td><?php echo $supplier->mobile_no; ?></td>
                    <td><?php echo $supplier->email; ?></td>
                    <td>
                      <a href="#" class="btn btn-primary edit1" data-id="<?php echo $supplier->id; ?>" data-toggle="modal" data-target="#editsupplier"> <i class="fas fa-edit"></i> Edit </a>
                      <a href="<?= base_url('supplier/delete/' . $supplier->id. "/".$supplier->supplier) ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this record?')"> <i
                          class="fas fa-trash"></i> Delete </a>
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
<div class="midde_cont">

  <div class="row column1">
    <div class="col-md-12" style="padding:5px;">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="table-responsive">

            <div class="d-flex justify-content-between mb-3">
              <h4>LIST OF SUPPLIER 2 </h4>
              <!-- <a href="#" class="btn btn-lg btn-success float-right" onclick="change()" data-toggle="modal"
                data-target="#addsupplier"> <i class="fas fa-plus"></i> Add New Category </a> -->
            </div>
            <table  class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">

              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">Raw Material</th>
                  <th width="15%">Category</th>
                  <th width="15%">Name</th>
                  <th width="15%">Address</th>
                  <th width="15%">City</th>
                  <th width="15%">Mobile Number</th>
                  <th width="15%">Email</th>
                  <th width="15%">Actions</th>
                </tr>

              <tbody>

                <?php $i = 1;

                foreach ($supplier_details2 as $supplier ) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php if($supplier->supplier=="first"){
                    foreach ($raw_material1 as $raw_id) {
                      if ($raw_id->id == $supplier->rawmaterial_id) {
                        echo $raw_id->name;
                      }
                    }}else{
                      foreach ($raw_material2 as $raw_id) {
                        if ($raw_id->id == $supplier->rawmaterial_id) {
                          echo $raw_id->name;
                        }
                      }
                    } ?></td>
                    <td><?php foreach ($category as $cat) {
                      if ($cat->id == $supplier->category_id) {
                        echo $cat->name;
                      }
                    } ?></td>
                    <td><?php echo $supplier->name; ?></td>
                    <td><?php echo $supplier->address; ?></td>
                    <td><?php echo $supplier->city; ?></td>
                    <td><?php echo $supplier->mobile_no; ?></td>
                    <td><?php echo $supplier->email; ?></td>
                    <td>
                      <a href="#" class="btn btn-primary edit2" data-id="<?php echo $supplier->id; ?>" data-toggle="modal" data-target="#editsupplier"> <i class="fas fa-edit"></i> Edit </a>
                      <a href="<?= base_url('supplier/delete/' . $supplier->id. "/".$supplier->supplier) ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this record?')"> <i
                          class="fas fa-trash"></i> Delete </a>
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
<!-- add supplier -->
<div class="modal fade" tabindex="-1" role="dialog" id="addsupplier">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('supplier/create'); ?>
    </div>
  </div>
</div>
<!-- end add supplier -->
<!-- edit supplier -->
<div class="modal fade" tabindex="-1" role="dialog" id="editsupplier">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('supplier/edit'); ?>
    </div>
  </div>
</div>
<!-- end edit supplier -->

<?php $this->load->view('supplier/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>