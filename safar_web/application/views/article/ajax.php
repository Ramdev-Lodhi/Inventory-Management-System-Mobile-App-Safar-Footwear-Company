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
  function editarticle(id) {
    var myurl = "<?php echo base_url('article/edit/'); ?>" + id;

    $.ajax({
      type: "GET",
      url: myurl,
      dataType: 'JSON',
      success: function (data) {

        // Update modal fields with received data
        $('#editarticle input[name="id"]').val(data.id);
        $('#editarticle input[name="name"]').val(data.name);
        $('#editarticle input[name="type"]').val(data.type);
        $('#editarticle input[name="category"]').val(data.category);
        $('#editarticle input[name="mrp"]').val(data.mrp);
        $('#editarticle input[name="package"]').val(data.package);
        $('#editarticle input[name="no_of_pairs"]').val(data.no_of_pairs);
        $('#editarticle input[name="photo"]').val(data.photo);

        // Update image preview
        $('#image').attr('src', "<?php echo base_url(); ?>" + data.photo);

        // Set radio buttons for 'is_active'
        // Fetch and check if 'is_active' is true or false
        var isActive = data.is_active;

        if (isActive == 1) { // Check for boolean true
          $('#editarticle input[name="is_active"][value="1"]').prop('checked', true);
          $('#editarticle input[name="is_active"][value="0"]').prop('checked', false);
        } else {
          $('#editarticle input[name="is_active"][value="1"]').prop('checked', false);
          $('#editarticle input[name="is_active"][value="0"]').prop('checked', true);
        }

        // Set form action to update with the correct article ID
        $('#editarticle form').attr('action', '<?php echo base_url("article/update/"); ?>' + data.id);
        // Show the modal
        $('#editarticle').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log("Response text:", xhr.responseText);
      }
    });
  }

</script>