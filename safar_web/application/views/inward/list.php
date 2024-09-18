<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Outter Box Inward</title>
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

          // bottom: {buttons: ['colvis','copyHtml5','csvHtml5','excelHtml5','pdfHtml5','print']}
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
          <div class="d-flex justify-content-between mb-3">
            <h4>LIST OF ALL RECORDs IN INWARDs</h4>
            <?php $user = $this->session->userdata();
            if ($user['role'] == 'admin') { ?>
              <a href="#" class="btn btn-lg btn-success float-right" data-toggle="modal" data-target="#addinward"
                onclick="change()"> <i class="fas fa-plus"></i> Add New</a>
            <?php } ?>
          </div>
          <div class="table-responsive">
            <table id="example" class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">
              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="15%">QR id</th>
                  <th width="15%">Article Name</th>
                  <th width="5%">Color</th>
                  <th width="5%">Size</th>
                  <th width="8%">No of Pairs</th>
                  <th width="10%">Godown Id</th>
                  <th width="10%">Status</th>
                  <th width="10%">Last Modified on</th>
                  <?php $user = $this->session->userdata();
                    if ($user['role'] == 'admin') { ?>
                  <th width="15%">Actions</th>
                  <?php }?>
                </tr>
              </thead>

              <tbody>

                <?php $i = 1;
                foreach ($data as $inward) { ?>

                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $inward->qr_id; ?></td>
                    <td><?php echo $inward->a_name; ?></td>
                    <td><?php echo $inward->a_color; ?></td>
                    <td><?php echo $inward->size; ?></td>
                    <td><?php echo $inward->no_of_pairs; ?></td>
                    <td><?php echo $inward->godown_id; ?></td>
                    <td><?php echo $inward->status; ?></td>
                    <td><?php echo $inward->modified_on; ?></td>
                    <?php $user = $this->session->userdata();
                    if ($user['role'] == 'admin') { ?>
                      <td>
                  
                        <a href="#" data-toggle="modal" data-id="<?php echo $inward->id; ?>" data-target="#editinward"
                          class="btn btn-lg btn-primary edit">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('inward/delete/' . $inward->id) ?>" class="btn btn-danger"
                          onclick="return confirm('Are you sure you want to delete this record?')"> <i
                            class="fas fa-trash"></i>
                          Delete </a>
                      </td>
                    <?php } ?>
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
<div class="modal fade" tabindex="-1" role="dialog" id="addinward">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('inward/create'); ?>
    </div>
  </div>
</div>
<!-- end add inward -->
<div class="modal fade" tabindex="-1" role="dialog" id="editinward">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('inward/edit'); ?>
    </div>
  </div>
</div>
<!-- end dashboard inner -->

<?php $this->load->view('inward/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>