<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Generate Label</title>
</head>
<style>
form label {
    font-weight: bold
}
</style>
<!-- siderbar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->
<!-- top header -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end top header -->


<div style="padding-top:5px;">
    <!-- dashboard inner -->
    <div class="midde_cont">
        <div class="row column1">
            <div class="col-md-12">
                <?php echo $this->session->flashdata('message'); ?>
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">



                        <div class="table-responsive">
                            <div class="d-flex justify-content-between mb-3">
                                <a href="<?= base_url('label/generate_label') ?>"
                                    class="btn btn-lg btn-primary">Generate Label</a>
                                <a href="<?= base_url('label/delete_all_labels') ?>"
                                    class="btn btn-lg btn-danger">Delete all labels</a>
                                <a href="#" class="btn btn-lg btn-success" onclick="change()" data-toggle="modal"
                                    data-target="#addlable"><i class="fas fa-plus"></i> Add New Label</a>
                                <button class="btn btn-lg btn-info" onclick="downloadSelectedLabels()">Download Excel</button>
                            </div>


                            <table class="table table-bordered table-default">
                                <thead class="thead-light">
                                    <tr align="center">
                                        <th width="2%">#</th>
                                        <th width="2%"><input type="checkbox" id="select_all"></th>
                                        <th width="15%">Label Type</th>
                                        <th width="15%">Quality</th>
                                        <th width="15%">Article</th>
                                        <th width="10%">Size</th>
                                        <th width="10%">Color</th>
                                        <th width="15%">No. of Pairs</th>
                                        <th width="33%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($label as $l) { ?>
                                    <tr align="center">
                                        <td><?php echo $i; ?></td>
                                        <td><input type="checkbox" class="select_item" value="<?php echo $l->id; ?>">
                                        </td>
                                        <td><?php echo ($l->label_type == 'outer') ? 'Outer' : 'Inner'; ?></td>
                                        <td><?php echo ($l->quality == 'second') ? 'Second' : 'First'; ?></td>
                                        <td><?php echo $l->name; ?></td>
                                        <td><?php echo $l->size; ?></td>
                                        <td><?php echo $l->color; ?></td>
                                        <td><?php echo $l->no_of_pairs; ?></td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-id="<?php echo $l->id; ?>"
                                                data-target="#editlable" class="btn  btn-primary edit"><i
                                                    class="fas fa-edit"></i> Edit</a>
                                            <a href="<?= base_url('label/delete/' . $l->id) ?>"
                                                class="btn  btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this record?')"><i
                                                    class="fas fa-trash"></i> Delete</a>
                                            <a href="#" data-toggle="modal" data-id="<?php echo $l->id; ?>"
                                                data-target="#qrlable" class="btn btn-lg btn-warning qr"><i
                                                    class="fas fa-qrcode"></i></a>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end dashboard inner -->
</div>
<!-- create lable -->
<div class="modal fade" tabindex="-1" role="dialog" id="addlable">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">
            <?php $this->load->view('label/create'); ?>
        </div>
    </div>
</div>
<!-- end create lable -->

<!-- edit lable -->
<div class="modal fade" tabindex="-1" role="dialog" id="editlable">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">

            <?php $this->load->view('label/edit'); ?>

        </div>
    </div>
</div>
<!-- end edit lable -->
<div class="modal fade" tabindex="-1" role="dialog" id="qrlable">
    <div class="modal-dialog" role="document" style="max-width: 800px; margin: 1.75rem auto;">
        <div class="modal-content">

            <?php $this->load->view('label/qrlink'); ?>

        </div>
    </div>
</div>
<script>
document.getElementById('select_all').addEventListener('click', function(event) {
    var checkboxes = document.querySelectorAll('.select_item');
    for (var checkbox of checkboxes) {
        checkbox.checked = event.target.checked;
    }
});
</script>
<script>
    function downloadSelectedLabels() {
        var selectedIds = [];
        var checkboxes = document.querySelectorAll('.select_item:checked');
        for (var checkbox of checkboxes) {
            selectedIds.push(checkbox.value);
        }

        if (selectedIds.length > 0) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('Label/download_selected_labels') ?>';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'label_ids';
            input.value = JSON.stringify(selectedIds);
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Please select at least one label to download.');
        }
    }
</script>

<?php $this->load->view('label/ajax'); ?>
<?php $this->load->view('includes/footer'); ?>