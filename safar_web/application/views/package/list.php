<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Package Size</title>
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
  <script type="text/javascript">
    window.onload = function exampleFunction() {
      var table = new DataTable('#example', {
        layout: {

      
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
      <?php echo $this->session->flashdata('message'); ?>
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="table-responsive">

            <div class="d-flex justify-content-between mb-3">
              <h4>LIST OF PACKAGE SIZE IN MASTER TABLES</h4>
              <a href="#" class="btn btn-lg btn-success float-right" data-toggle="modal" data-target="#addpackage"> <i
                  class="fas fa-plus"></i> Add New Package Size </a>
            </div>
            <table id="example" class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">

              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">Category</th>
                  <th width="15%">Size</th>
                  <th width="15%">Actions</th>
                </tr>
         
            <tbody>
              
            <?php $i = 1;
                foreach ($data as $package) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php foreach($category as $cat ){
                        if($cat->id == $package->category_id){
                            echo $cat->name;
                        }
                    } ?></td>
                   <td><?php echo $package->size ?></td>
                    <td>
                    
                      <a href="#" class="btn btn-primary" onclick="edit_package(<?php echo $package->id ?>)" data-toggle="modal"
                        data-target="#editpackage"> <i class="fas fa-edit"></i> Edit </a>
                      <a href="<?= base_url('package/delete/' . $package->id) ?>" class="btn btn-danger"
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
<!-- add package -->
<div class="modal fade" tabindex="-1" role="dialog" id="addpackage">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('package/create'); ?>
    </div>
  </div>
</div>
<!-- end add package -->
<!-- edit package -->
<div class="modal fade" tabindex="-1" role="dialog" id="editpackage">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('package/edit'); ?>
    </div>
  </div>
</div>
<!-- end edit package -->

<?php $this->load->view('package/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>