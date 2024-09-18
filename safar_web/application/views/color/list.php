<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title> Color</title>
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
    form label {font-weight:bold}
  </style>
  <!-- JS for DataTables -->
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
  <!-- Page Content  -->
  <div class="row column1">
    <div class="col-md-12" style="padding:5px;">
        <?php echo $this->session->flashdata('message'); ?>
      <div class="white_shd full margin_bottom_30">

        <div class="full graph_head">
       
          <div class="d-flex justify-content-between mb-3">
          <h4> LIST OF ALL COLORS IN MASTER TABLES </h4>
            <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#addcolor"><i
                class="fas fa-plus"></i>
              Add
              New Color</a>
          </div>


          <div class="table-responsive">
            <table id="example" class="table table-bordered table-default table-hover" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">Category</th>
                  <th width="15%">Color name</th>
                  <th width="15%">Actions</th>
                </tr>
              </thead>

              <tbody>
              <?php $i = 1;
                  foreach ($data as $color) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                    
                      <td><?php foreach($category as $cat ){ if($cat->id == $color->category_id) {
                     echo $cat->name;  }} ?></td>
                      <td><?php echo $color->color; ?></td>

                      <td>
                       
                        <a href="#" class="btn btn-primary" onclick="edit_color(<?php echo $color->id ?>)"
                          data-toggle="modal" data-target="#editcolor"> <i class="fas fa-edit"></i> Edit </a>
                        <a href="<?= base_url('color/delete/' . $color->id) ?>" class="btn btn-danger"
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
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- add  color-->
  <div class="modal fade" tabindex="-1" role="dialog" id="addcolor">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
      <div class="modal-content">
        <?php $this->load->view('color/create'); ?>
      </div>
    </div>
  </div>
  <!-- end add  color-->

  <!-- start edit color -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editcolor">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
      <div class="modal-content">
        <?php $this->load->view('color/edit') ?>
      </div>
    </div>
  </div>
 
  <?php $this->load->view('color/ajax'); ?>
  <?php $this->load->view('includes/footer'); ?>
  <!-- end dashboard inner -->