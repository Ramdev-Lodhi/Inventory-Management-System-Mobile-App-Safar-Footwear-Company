<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Safar Footwear</title>
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
      font-family: sans-serif;
      /* font-size: 16px; */
    }

    table.dataTable td.dt-type-numeric,
    table.dataTable td.dt-type-date {
      text-align: center;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #dc3545;
    }
    .modal-body-scrollable {
    max-height: 650px; /* Adjust the height as needed */
    overflow-y: auto;
}

  </style>
  <!-- JS for DataTables -->
  <script type="text/javascript">
    window.onload = function exampleFunction() {
      var table = new DataTable('#example', {
        layout: {
          top: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
          }
        },
        pagingType: 'simple_numbers',
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

<div class="midde_cont">
  <div class="row column1">
    <div class="col-md-12" style="padding:5px;">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="col-sm-12" style="padding-top: 15px;">
            <div class="d-flex justify-content-between mb-3">
              <?php echo $this->session->flashdata('message'); ?>
              <h4>RECORD OF CARTON IN BOTH GODOWN</h4>
            </div>
            <table id="example" class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">
              <thead class="thead-light">
                <tr>
                  <th width="2%">#</th>
                  <th width="25%">Article Name</th>
                  <th width="23%">Color</th>
                  <th width="10%">Size</th>
                  <th width="10%">Quality</th>
                  <th style="background-color:pink" width="15%">Quantity in Godown 1</th>
                  <th style="background-color:orange" width="15%">Quantity in Godown 2</th>
                  <th width="10%">Total Quantity</th>
                  <th width="20%">Actions</th>
                </tr>
              </thead>

              <tbody>

                <?php $i = 1;
                foreach ($data as $d) { ?>
                  <?php foreach ($d['color'] as $c) { ?>
                    <?php foreach ($c['size'] as $s) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $d['article_name']; ?></td>
                        <td><?php echo $c['color_name']; ?></td>
                        <td><?php echo $s['size_name']; ?></td>
                        <td><?php echo $c['quality']; ?></td>

                        <td style="background-color:pink"><?php echo $s['quantity_in_g1']; ?></td>
                        <td style="background-color:orange"><?php echo $s['quantity_in_g2']; ?></td>
                        <td><?php echo ($s['quantity_in_g1'] + $s['quantity_in_g2']); ?></td>

                        <td>
                          <a href="#" class="btn  btn-success float-right details "
                            data-id="<?php echo $d['aid'] . '->' . $c['color_id'] . '->' . $s['size_name'] . '->' . $c['quality']; ?>"
                            data-toggle="modal" data-target="#viewdetails"><i class="fas fa-eye"></i> Details
                          </a>
                          <!-- <a href="#" class="btn btn-primary"> <i class="fas fa-edit"></i> Edit </a> -->
                          <!-- <a href="#" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')"> <i class="fas fa-trash"></i> Delete </a> -->
                        </td>

                      </tr>

                      <?php $i++;
                    }
                  }

                } ?>

              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="viewdetails">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <div class="modal-body modal-body-scrollable">
        <?php $this->load->view('godown_stock/view'); ?>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('godown_stock/ajax'); ?>

<?php $this->load->view('includes/footer'); ?>