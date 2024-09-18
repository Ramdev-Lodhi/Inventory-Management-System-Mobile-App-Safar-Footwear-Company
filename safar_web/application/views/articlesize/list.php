<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Article Size</title>
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
<!-- Sidebar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->

<!-- topbar -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end topbar -->

<!-- dashboard inner -->
<div class="midde_cont">
  <div class="row">

    <div class="row column1">
      <div class="col-md-12" style="padding:20px;">
        <div class="white_shd full margin_bottom_30">
          <div class="full graph_head">
            <!-- Page Content  -->
            <div class="d-flex justify-content-between mb-3" style="padding-top: 15px;">
              <?php echo $this->session->flashdata('message'); ?>
              <h4></h4>
              <a href="<?= base_url('articlesize/create') ?>" class="btn btn-success float-right"> <i
                  class="fas fa-plus"></i>
                Add New Article Size</a>
            </div>

            <div class="table-responsive">
              <table id="example" class="table table-bordered table-default table-hover"
                style="background-color:#FDF5E6; width:100%">
                <thead class="thead-light">
                  <tr>
                    <th width="2%">#</th>
                    <th width="25%">Article Name</th>
                    <th width="25%">Article Color</th>
                    <th width="18%">Size</th>
                    <th width="30%">Actions</th>
                  </tr>
                </thead>

                <tbody>

                  <?php $i = 1;
                  foreach ($data as $s) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $s['name']; ?></td>
                      <td><?php echo $s['color']; ?></td>
                      <td><?php echo $s['size']; ?></td>
                      <td>
                        <a href="<?= base_url('articlesize/edit/' . $s['id']) ?>" class="btn btn-primary"> <i
                            class="fas fa-edit"></i> Edit </a>
                        <a href="<?= base_url('articlesize/delete/' . $s['id']) ?>" class="btn btn-danger"
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
</div>

<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>