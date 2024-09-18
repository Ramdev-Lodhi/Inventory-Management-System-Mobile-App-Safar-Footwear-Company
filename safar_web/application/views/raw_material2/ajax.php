<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  var i = 1;

  function previewImage(input) {

    const file = input[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const newImage = document.createElement("div");
        newImage.className = "product-images";
        newImage.id = `product-images-${i - 1}`;
        newImage.innerHTML = `<img src="${e.target.result}" alt="uploaded image" ><p id="${i - 1}" onclick="removeElement(this.id);">Remove</p>`;

        document.querySelector(".product-images-div").appendChild(newImage);
      };
      reader.readAsDataURL(file);
    }
    document.querySelector(`.add-images`).style.visibility = "hidden";
    document.querySelector(`.add-images`).style.position = "absolute";

    i++;


  }

  function removeElement(index) {
    document.getElementById(`product-images-${index}`).remove();
    document.getElementById(`drop-zone-input-${index}`).remove();
    document.querySelector(`.add-images`).style.visibility = "visible";
    document.querySelector(`.add-images`).style.position = "relative";
    addInput();
  }

  function addInput() {
    var newInput = document.createElement('input');
    newInput.type = "file";
    newInput.name = "product-image[]";
    newInput.className = "drop-zone-input";
    newInput.id = `drop-zone-input-${i}`;
    newInput.addEventListener("change", function () {
      previewImage(this.files);
    });
    document.querySelector(".drop-zone-small").appendChild(newInput);
  }
</script>
<script>
  var i = 1;

  function previewImage1(input) {

    const file = input[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const newImage = document.createElement("div");
        newImage.className = "product-images";
        newImage.id = `product-images-${i - 1}`;
        newImage.innerHTML = `<img src="${e.target.result}" alt="uploaded image" ><p id="${i - 1}" onclick="removeElement_edit(this.id);">Remove</p>`;

        document.querySelector(".product-images-div1").appendChild(newImage);
      };
      reader.readAsDataURL(file);
    }
    document.querySelector(`.add-images_edit`).style.visibility = "hidden";
    document.querySelector(`.add-images_edit`).style.position = "absolute";

    i++;


  }

  function removeElement_edit(index) {
    document.getElementById(`product-images-${index}`).remove();
    document.getElementById(`drop-zone-input-${index}`).remove();
    document.querySelector(`.add-images_edit`).style.visibility = "visible";
    document.querySelector(`.add-images_edit`).style.position = "relative";
    addInput_edit();
  }

  function addInput_edit() {
    var newInput = document.createElement('input');
    newInput.type = "file";
    newInput.name = "product-image[]";
    newInput.className = "drop-zone-input1";
    newInput.id = `drop-zone-input-${i}`;
    newInput.addEventListener("change", function () {
      previewImage(this.files);
    });
    document.querySelector(".drop-zone-small").appendChild(newInput);
  }
</script>
<script>
  $(document).on('click', '.edit', function () {

    var id = $(this).data('id');
    var myurl = "<?php echo base_url('rawmaterial/raw_material2_edit/'); ?>" + id;
    $.ajax({
      type: 'POST',
      url: myurl,
      dataType: 'json',
      data: { id: id },
      success: function (response) {
        console.log(response);
        $('#edit_raw_material2 input[name="name"]').val(response.name);
        $('#edit_raw_material2 input[name="sub_name"]').val(response.sub_name);
        $('#edit_raw_material2 input[name="color"]').val(response.color);
        $('#edit_raw_material2 input[name="design"]').val(response.design);
        $('#edit_raw_material2 input[name="size"]').val(response.size);
        $('#edit_raw_material2 input[name="thickness"]').val(response.thickness);
        $('#edit_raw_material2 input[name="quantity"]').val(response.quantity);
        $('#edit_raw_material2 input[name="unit"]').val(response.unit);
        $('#edit_raw_material2 input[name="threshold"]').val(response.threshold);
        $('[name="category"] option[value="' + response.category + '"]').prop('selected', true);
        $('#edit_raw_material2 input[name="photo"]').val(response.photo);
        // Update image preview
        $('#image').attr('src', "<?php echo base_url(); ?>" + response.photo);
        $('#edit_raw_material2').modal('show');
      }

    });

    $('#edit_raw_material2 form').attr('action', '<?php echo base_url("rawmaterial/raw_material2_update/"); ?>' + id);

  });
</script>