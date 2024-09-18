<!-- dashboard inner -->
<div class="col-md-12" style="padding:20px;">
    <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
            <div class="col-lg-12 my-2">
                <h1 class="text-center mb-3">Qr Link</h1>
            </div>
            <div class="d-flex justify-content-end ">
                <a class="btn btn-warning btn-lg" href="<?php echo base_url('label'); ?>"> <i
                        class="fas fa-angle-left"></i>
                    Back</a>
            </div>
        </div>
        <div class="padding_infor_info">

            <div class="form-group">
                <label for="qr">Qr Link</label>
                <input class="form-control" type="text" name="qr" id="qr" value="Your QR link here" disabled>
            </div>

            <div class="form-group text-right" style="margin-top:20px;">
                <button type="button" class="btn btn-lg btn-success" id="copyButton"> <i class="fas fa-check"></i> Copy
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end dashboard inner -->
<script>
document.getElementById('copyButton').addEventListener('click', function() {
    var qrInput = document.getElementById('qr');
    var textToCopy = qrInput.value;

    navigator.clipboard.writeText(textToCopy)
        .then(function() {
            alert('Text copied to clipboard');
        window.location.href = '<?php echo base_url('label'); ?>';
        })
        .catch(function(err) {
            console.error('Unable to copy text: ', err);
            alert('Failed to copy text to clipboard');
          
        });
});
</script>
