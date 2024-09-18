<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Raw Material</title>
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

    table.table.dataTable> :not(caption)>> {
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
    label{

        font-weight: bold;
    }
    td{
        font-weight: bold;
    }
  </style>
  <!-- JS for DataTables -->
  <script type="text/javascript">
    window.onload = function exampleFunction() {
      var table = new DataTable('#example', {
          layout: {
              //bottom: {buttons: ['colvis','copyHtml5','csvHtml5','excelHtml5','pdfHtml5','print']}
            },
            "pageLength":50,
            "bSort":false,
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
    <div class="col-md-12" style="padding:20px;">
      <?php echo $this->session->flashdata('message'); ?>
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="table-responsive">

            <div class="d-flex justify-content-between mb-3">
              <h4>MATERIAL REQUIRED</h4>
              <a href="#" class="btn btn-success float-right" data-toggle="modal" data-target="#addmaterial_required"> <i class="fas fa-plus"></i> Add New </a>
            </div>
            <table id="example" class="table table-bordered table-default table-hover"
              style="background-color:#FDF5E6;width:100%;">
              <thead class="thead-light">
                <tr>
                  <th>Artical Name</th>
                  <?php foreach ($data as $index => $material) { ?>
                    <th>
                    
                    <?= $material->a_name ?>
                    
                </th>
                  <?php } ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>Color</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal" ><?= $material->color ?></td>
                  <?php } ?>
                </tr>
                <!-- <tr>
                  <td>#</td>
                  <?php //foreach ($data as $index => $material) { ?>
                    <td><? //$index + 1 ?></td>
                  <?php //} ?>
                </tr> -->
                <!-- <tr>
                  <td>Artical Name</td>
                  <?php //foreach ($data as $material) { ?>
                    <td><?// $material->a_name ?></td>
                  <?php //}// ?>
                </tr> -->
                <tr>
                  <td>Polyurethane</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->polyurethane ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>Isocyanates</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->isocyanates ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>Catalysts</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->catalysts ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>Pigment</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->pigment ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>Rising Chemical</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->rising_chemical ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>Skin Chemical</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->skin_chemical ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>Releasing Agent</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->releasing_agent ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>MCL</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->mcl ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>ELFI GLUE</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->elfi_glue ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>PVC BAGS</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->pvc_bags ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>LIFTER</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->lifter ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>BUTTER PAPER</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->butter_paper ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>LD BAGS</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->ld_bags ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>OUTTER LABEL</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->outter_label ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>INNER LABEL</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->inner_label ?></td>
                  <?php } ?>
                </tr>
                <tr>
                  <td>REXINE</td>
                  <?php foreach ($data as $material) { ?>
                    <td style="font-weight:normal"><?= $material->rexine ?></td>
                  <?php } ?>
                </tr>
            </tbody>
            <tr>
              <td>Action</td>
              <?php foreach ($data as $material) { ?>
                <td>
                  <a href="#" data-toggle="modal" data-id="<?= $material->id; ?>"
                    data-target="#editmaterial_required" class="btn  btn-info edit">
                    <i class="fas fa-edit"></i> Edit&nbsp&nbsp&nbsp
                  </a>
                  <a href="<?= base_url('rawmaterial/material_required_delete/' . $material->id) ?>" class="btn  btn-danger"
                    onclick="return confirm('Are you sure you want to delete this record?')">
                    <i class="fas fa-trash"></i> Delete </a>
                </td>
              <?php } ?>
            </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end dashboard inner -->
<!-- add material_required -->
<div class="modal fade" tabindex="-1" role="dialog" id="addmaterial_required">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('material_required/create'); ?>
    </div>
  </div>
</div>
<!-- end add material_required -->
<div class="modal fade" tabindex="-1" role="dialog" id="editmaterial_required">
  <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
    <div class="modal-content">
      <?php $this->load->view('material_required/edit'); ?>
    </div>
  </div>
</div>
<?php $this->load->view('material_required/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>