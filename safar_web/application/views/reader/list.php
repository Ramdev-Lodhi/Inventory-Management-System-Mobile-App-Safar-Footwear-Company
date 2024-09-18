<!doctype html>
<html lang="en">


<head>
    <?php $this->load->view('includes/header'); ?>
    <title>Reader</title>
    <script src="https://cdn.jsdelivr.net/npm/raphael@2.3.0/raphael.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/justgage@1.3.5/justgage.min.js"></script>
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
        /* width: 50%; */
        height: 50px;
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

    .input-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        flex-direction: column;
        align-items: center;
    }

    .lists-container {
        display: flex;
        justify-content: space-between;
    }

    .list {
        width: 48%;
    }

    .clear-button {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #dc3545;
        color: white;
        border: none;
        height: 50px;
        width: 90px;
        border-radius: 5px;
        display: none;
    }

    .logout-button {
        margin-left: 10px;
        height: 40px;
        border-radius: 10px;
        border: none;
        color: white;
        background-color: #FFA500;
        padding: 5px 10px;
        font-size: 16px;
        /* text-align:center; */

    }

    .logout-button:hover {
        color: white;
    }

    .submit-button {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: blue;
        color: white;
        border: none;
        height: 50px;
        width: 80px;
        border-radius: 5px;
        display: none;
    }

    .remove-cell {
        width: 20px;
        /* Fixed width for remove cell */
        text-align: center;
        cursor: pointer;


    }

    .remove-cell:hover {
        background-color: red;
        color: white;
    }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        function checkInternetConnection() {
            $.ajax({
                url: '<?php echo base_url('reader/check_internet'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.connected) {
                        $('.internetconnectionstatuts').html(
                            '<div class="successconnection" style="color:green;">इंटरनेट चालू है |<img src="<?php echo base_url('images/logo/wifi.png'); ?>" alt="image" style="height: 100px;"></div>'
                            );
                    } else {
                        $('.internetconnectionstatuts').html(
                            '<div class="Failedconnection" style="color:red;">इंटरनेट बंद है |<img src="<?php echo base_url('images/logo/no-internet.png'); ?>" alt="image" style="height: 100px;"></div>'
                            );
                    }
                },
                error: function(xhr, status, error) {
                    $('.internetconnectionstatuts').html(
                        '<div class="Failedconnection"><img src="<?php echo base_url('images/logo/no-internet.png'); ?>" alt="image" style="height: 100px;"></div>'
                        );
                }
            });
        }

        // Check the connection status every 5 seconds
        setInterval(checkInternetConnection, 5000);

        // Call the function on page load
        checkInternetConnection();


    });
    var maintainAutofocus = true;

    function ButtonsVisibility() {
        var qrCodeList = document.getElementById('qrCodeList').getElementsByTagName('tbody')[0];
        var barcodeList = document.getElementById('barcodeList').getElementsByTagName('tbody')[0];
        var clearBtn = document.getElementById('clearBtn');
        var submitBtn = document.getElementById('submitBtn');

        var qrCodeCount = qrCodeList.rows.length;
        var barcodeCount = barcodeList.rows.length;

        if (qrCodeCount > 0 || barcodeCount > 0) {
            clearBtn.style.display = 'inline-block';
        } else {
            clearBtn.style.display = 'none';
            submitBtn.style.display = 'none';
        }

        if (qrCodeCount > 0 && barcodeCount > 0) {
            submitBtn.style.display = 'inline-block';
        } else {
            submitBtn.style.display = 'none';
        }
    }

    function showLists() {
        var input = document.getElementById('myTextBox');
        var clearBtn = document.getElementById('clearBtn');
        var submitBtn = document.getElementById('submitBtn');
        ButtonsVisibility();
        if (input.value.trim() !== '') {
            // clearBtn.style.display = 'inline-block';
            // submitBtn.style.display = 'inline-block';
            localStorage.setItem('listsVisible', 'true');
        } else {
            // clearBtn.style.display = 'none';
            // submitBtn.style.display = 'none';
            localStorage.setItem('listsVisible', 'true');
        }

        input.focus();

    }

    function clearInput() {
        var confirmed = confirm('Are you sure you want to Clear the data? \n क्या आप वाकई डेटा साफ़ करना चाहते हैं?');
        if (!confirmed) {
            return;
        }
        var input = document.getElementById('myTextBox');
        var clearBtn = document.getElementById('clearBtn');
        var submitbtn = document.getElementById('submitBtn');
        var qrCodeList = document.getElementById('qrCodeList');
        var barcodeList = document.getElementById('barcodeList');

        input.value = '';
        input.focus();
        qrCodeList.getElementsByTagName('tbody')[0].innerHTML = '';
        barcodeList.getElementsByTagName('tbody')[0].innerHTML = '';
        qrCodeList.style.display = 'block';
        barcodeList.style.display = 'block';
        submitbtn.style.display = 'none';
        clearBtn.style.display = 'none';
        localStorage.setItem('listsVisible', 'true');
        localStorage.removeItem('qrCodes');
        localStorage.removeItem('barcodes');
        updateListCount();
    }

    window.onload = function() {

        var input = document.getElementById('myTextBox');
        var clearBtn = document.getElementById('clearBtn');
        var submitBtn = document.getElementById('submitBtn');
        var qrCodeList = document.getElementById('qrCodeList');
        var barcodeList = document.getElementById('barcodeList');

        input.focus();

        qrCodeList.style.display = 'block';
        barcodeList.style.display = 'block';



        var qrCodes = JSON.parse(localStorage.getItem('qrCodes')) || [];
        qrCodes.forEach(item => addItemToList('qrCodeList', item));

        var barcodes = JSON.parse(localStorage.getItem('barcodes')) || [];
        barcodes.forEach(item => addItemToList('barcodeList', item));

        clearBtn.style.display = 'inline-block';
        submitBtn.style.display = 'inline-block';
        updateListCount();
        ButtonsVisibility();


    };

    function addItemToList(listId, item) {
        var list = document.getElementById(listId).getElementsByTagName('tbody')[0];
        var row = list.insertRow();
        var cell = row.insertCell(0);
        cell.textContent = item;
        cell.style.border = '1px solid black';

        var removeCell = row.insertCell(1);
        removeCell.classList.add('remove-cell');
        removeCell.style.border = '1px solid black';
        var removeButton = document.createElement('span');
        removeButton.textContent = '❌';
        removeButton.classList.add('remove-item');
        removeButton.onclick = function() {
            list.deleteRow(row.rowIndex - 1);
            saveListsToLocalStorage();
            updateListCount();
            ButtonsVisibility();

            document.getElementById('myTextBox').focus();
        };
        removeCell.appendChild(removeButton);
        // removeCell.style.textAlign = 'center'; 
        updateListCount();
        ButtonsVisibility();
    }

    function saveListsToLocalStorage() {
        var qrCodeList = document.getElementById('qrCodeList').getElementsByTagName('tbody')[0];
        var qrCodes = [];
        for (var i = 0; i < qrCodeList.rows.length; i++) {
            qrCodes.push(qrCodeList.rows[i].cells[0].textContent);
        }
        localStorage.setItem('qrCodes', JSON.stringify(qrCodes));

        var barcodeList = document.getElementById('barcodeList').getElementsByTagName('tbody')[0];
        var barcodes = [];
        for (var i = 0; i < barcodeList.rows.length; i++) {
            barcodes.push(barcodeList.rows[i].cells[0].textContent);
        }
        localStorage.setItem('barcodes', JSON.stringify(barcodes));
    }

    document.addEventListener('keydown', function(event) {
        var input = document.getElementById('myTextBox');
        if (event.key === 'Enter' && input.value.trim() !== '') {
            handleScannedInput(input.value.trim());
            input.value = '';
            input.focus();
        }
    });

    function handleScannedInput(item) {
        if (isBarcode(item)) {
            addItemToList('barcodeList', item);
        } else {
            addItemToList('qrCodeList', item);
        }
        showLists();
        saveListsToLocalStorage();
    }

    function isBarcode(item) {
        return item.startsWith('BC') || item.length <= 25;
    }

    function updateListCount() {
        var qrCodeCount = document.getElementById('qrCodeList').getElementsByTagName('tbody')[0].rows.length;
        var barcodeCount = document.getElementById('barcodeList').getElementsByTagName('tbody')[0].rows.length;

        document.getElementById('qrCodeCount').textContent = qrCodeCount;
        document.getElementById('barcodeCount').textContent = barcodeCount;
    }


    document.addEventListener('click', function(event) {
        var input = document.getElementById('myTextBox');
        if (event.target !== input) {
            input.focus();
        }
    });

    function submitData() {
        // var confirmed = confirm('Are you sure you want to submit the data?\n क्या आप वाकई डेटा सबमिट करना चाहते हैं?');
        //     if (!confirmed) {
        //         return;
        //     }
        var qrCodeList = document.getElementById('qrCodeList').getElementsByTagName('tbody')[0];
        var barcodeList = document.getElementById('barcodeList').getElementsByTagName('tbody')[0];
        if (qrCodeList.rows.length > 1) {
            alert(
                ' ⚠️ Outer Box Only One Entry Allowed !\nआउटर बॉक्स मैं केवल एक ही एंट्री होनी चाहिए |\n\nError submitting data.\n डेटा सबमिट करते समय त्रुटि .......');
            return; // Exit the function to prevent the modal from opening
        }

        var qrCodes = [];
        // for (var i = 0; i < qrCodeList.rows.length; i++) {
        qrCodes.push(qrCodeList.rows[0].cells[0].textContent);
        // }


        var barcodes = [];
        for (var i = 0; i < barcodeList.rows.length; i++) {
            barcodes.push(barcodeList.rows[i].cells[0].textContent);
        }

        // Prepare the tables in the modal
        var qrTableBody = document.getElementById('qrTableBody');
        var barcodeTableBody = document.getElementById('barcodeTableBody');
        qrTableBody.innerHTML = '';
        barcodeTableBody.innerHTML = '';


        function addRow(tableBody, data, index) {
            var row = tableBody.insertRow(-1);
            var serialCell = row.insertCell(0);
            serialCell.textContent = index + 1; // Serial number starts from 1
            serialCell.style.border = '1px solid black';
            serialCell.style.width = '20px';

            var dataCell = row.insertCell(1);
            dataCell.textContent = data;
            dataCell.style.border = '1px solid black';
        }

        // Populate QR codes table
        qrCodes.forEach(function(qrCode, index) {
            addRow(qrTableBody, qrCode, index);
        });

        // Populate barcodes table
        barcodes.forEach(function(barcode, index) {
            addRow(barcodeTableBody, barcode, index);
        });

        // Show the modal
        $('#confirmModal').modal('show');

        var qr_data = {
            'qrCodes': qrCodes,
            'barcodes': barcodes
        };


        document.getElementById('confirmSubmitButton').onclick = function() {
            // Send AJAX request to CodeIgniter controller method
            $.ajax({
                url: '<?php echo base_url('reader/insert_ajax'); ?>',
                type: 'POST',
                data: qr_data,
                dataType: 'json',
                success: function(response) {
                    console.log('Success:', response);
                    alert('Data submitted successfully!\nडेटा सफलतापूर्वक सबमिट किया गया है!');
                    var input = document.getElementById('myTextBox');
                    var clearBtn = document.getElementById('clearBtn');
                    var submitbtn = document.getElementById('submitBtn');
                    var qrCodeList = document.getElementById('qrCodeList');
                    var barcodeList = document.getElementById('barcodeList');

                    input.value = '';
                    input.focus();
                    qrCodeList.getElementsByTagName('tbody')[0].innerHTML = '';
                    barcodeList.getElementsByTagName('tbody')[0].innerHTML = '';
                    qrCodeList.style.display = 'block';
                    barcodeList.style.display = 'block';
                    submitbtn.style.display = 'none';
                    clearBtn.style.display = 'none';
                    localStorage.setItem('listsVisible', 'true');
                    localStorage.removeItem('qrCodes');
                    localStorage.removeItem('barcodes');
                    updateListCount();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Error submitting data.\n डेटा सबमिट करते समय त्रुटि.');
                }
            });
            // Hide the modal
            $('#confirmModal').modal('hide');
        };
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>

<body>
<?php $user = $this->session->userdata();
if ($user['role'] == 'admin') { ?>
<?php $this->load->view('includes/sidebar'); ?>
<?php $this->load->view('includes/top_header'); ?>
<?php } ?>
    <div class="midde_cont">
        <div class="row column1">
            <div class="col-md-12" style="padding:20px;">
                <!-- Your PHP session message display -->
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="d-flex justify-content-end mb-3">

                            <div class="internetconnectionstatuts" style="width: 120px; height:30px;">
                                <?php echo $connection; ?>
                            </div>
                        </div>
                        <br>
                        <div class="input-container ">
                            <input class="form-control" style="width: 50%;" type="text" id="myTextBox" autofocus
                                oninput="showLists()">

                        </div>
                        <div class="lists-container">
                            <div id="barcodeList" class="list">
                                <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-default table-hover"
                                        style="background-color:#FDF5E6;width:100%; border:1px solid black">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2"
                                                    style="text-align:center; font-weight:bold;border:1px solid black">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <span> Inner Box (Barcode) </span>
                                                        <div>

                                                            Total: <span id="barcodeCount" style="color:green"> 0</span>
                                                        </div>
                                                    </div>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="qrCodeList" class="list">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-default table-hover"
                                        style="background-color:#FDF5E6;width:100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2"
                                                    style="text-align:center; font-weight:bold;border:1px solid black">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <span> Outer Box (QR Code) </span>
                                                        <div>

                                                            Total: <span id="qrCodeCount" style="color:green"> 0</span>
                                                        </div>
                                                    </div>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <button id="submitBtn" class="submit-button " onclick="submitData()">Submit</button>
                            <button id="clearBtn" class="clear-button " onclick="clearInput()">Clear</button>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end mb-3">
                            <a class="logout-button" href="<?php echo site_url('Logout'); ?>">Logout</a>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
           <img src="<?= base_url('images/logo/loading.png')?>"  onclick="location.reload()" alt="image"  width="15px" height="15px">
        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- modal comfirm -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 80%; margin: 1.75rem auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Data Submission</h5>
                    <h5 class="modal-title" id="confirmModalLabel">(डेटा सबमिशन की पुष्टि करें)</h5>

                </div>
                <div class="modal-body">
                    <!-- <p>You are about to submit the following data(आप निम्नलिखित डेटा सबमिट करने वाले हैं):</p> -->
                    <p>आप निम्नलिखित डेटा सबमिट करने वाले हैं:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2"
                                                style="text-align:center; font-weight:bold;border:1px solid black">
                                                Inner
                                                Box (Barcode)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="barcodeTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2"
                                                style="text-align:center; font-weight:bold;border:1px solid black">
                                                Outer
                                                Box (QR Code)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="qrTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmitButton">submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal comfirm -->


<?php $this->load->view('includes/footer'); ?>