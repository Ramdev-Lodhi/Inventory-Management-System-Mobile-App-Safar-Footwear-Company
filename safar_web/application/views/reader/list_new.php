<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raw Material</title>
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
            width: 50%;
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
            border-radius: 5px;
            display: none;
        }

        .remove-item {
            color: red;
            cursor: pointer;
        }
    </style>
    <script type="text/javascript">
        function showLists() {
            var input = document.getElementById('myTextBox');
            var clearBtn = document.getElementById('clearBtn');
            var list1 = document.getElementById('qrCodeList');
            var list2 = document.getElementById('barcodeList');

            if (input.value.trim() !== '') {
                list1.style.display = 'block';
                list2.style.display = 'block';
                clearBtn.style.display = 'inline-block';
                localStorage.setItem('listsVisible', 'true');
            } else {
                list1.style.display = 'none';
                list2.style.display = 'none';
                clearBtn.style.display = 'none';
                localStorage.setItem('listsVisible', 'false');
            }
        }

        function clearInput() {
            var input = document.getElementById('myTextBox');
            var clearBtn = document.getElementById('clearBtn');
            var qrCodeList = document.getElementById('qrCodeList');
            var barcodeList = document.getElementById('barcodeList');

            input.value = '';
            input.focus();
            qrCodeList.getElementsByTagName('tbody')[0].innerHTML = '';
            barcodeList.getElementsByTagName('tbody')[0].innerHTML = '';
            qrCodeList.style.display = 'none';
            barcodeList.style.display = 'none';
            clearBtn.style.display = 'none';
            localStorage.setItem('listsVisible', 'false');
            localStorage.removeItem('qrCodes');
            localStorage.removeItem('barcodes');

            updateListCount();
        }

        window.onload = function() {
            var input = document.getElementById('myTextBox');
            var clearBtn = document.getElementById('clearBtn');
            var qrCodeList = document.getElementById('qrCodeList');
            var barcodeList = document.getElementById('barcodeList');

            input.focus();

            if (localStorage.getItem('listsVisible') === 'true') {
                qrCodeList.style.display = 'block';
                barcodeList.style.display = 'block';
                clearBtn.style.display = 'inline-block';
            }

            // Load QR Codes from localStorage
            var qrCodes = JSON.parse(localStorage.getItem('qrCodes')) || [];
            qrCodes.forEach(item => addItemToList('qrCodeList', item));

            // Load Barcodes from localStorage
            var barcodes = JSON.parse(localStorage.getItem('barcodes')) || [];
            barcodes.forEach(item => addItemToList('barcodeList', item));

            updateListCount();
        };

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
            updateListCount();
        }

        function isBarcode(item) {
            return item.startsWith('BC') || item.length <= 25;  
        }

        function addItemToList(listId, item) {
            var list = document.getElementById(listId).getElementsByTagName('tbody')[0];
            var row = list.insertRow();
            var cell = row.insertCell(0);
            cell.textContent = item;

            // Add cross button for removal
            var removeButton = document.createElement('span');
            removeButton.textContent = '❌';
            removeButton.classList.add('remove-item');
            removeButton.onclick = function() {
                list.deleteRow(row.rowIndex);
                saveListsToLocalStorage();
                updateListCount();
            };
            cell.appendChild(removeButton);
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

        function updateListCount() {
            var qrCodeCount = document.getElementById('qrCodeList').getElementsByTagName('tbody')[0].rows.length;
            var barcodeCount = document.getElementById('barcodeList').getElementsByTagName('tbody')[0].rows.length;

            document.getElementById('qrCodeCount').textContent = qrCodeCount;
            document.getElementById('barcodeCount').textContent = barcodeCount;
        }
    </script>
</head>
<body>
    <div class="midde_cont">
        <div class="row column1">
            <div class="col-md-12" style="padding:20px;">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="input-container">
                            <input class="form-control" style="width: 50%;" type="text" id="myTextBox" autofocus oninput="showLists()">
                            
                        </div>

                        <div class="lists-container">
                            <div id="barcodeList" class="list" style="display:none;">
                                <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-default table-hover" style="background-color:#FDF5E6;width:100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2" style="text-align:center; font-weight:bold">Inner Box (Barcode)  Count: <span id="barcodeCount">0</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="qrCodeList" class="list" style="display:none;">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-default table-hover" style="background-color:#FDF5E6;width:100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2" style="text-align:center; font-weight:bold">Outer Box (QR Code)   Count: <span id="qrCodeCount">0</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <button id="clearBtn" class="clear-button" onclick="clearInput()">Clear</button>
                        <button id="submitButton" class="submit-button">Submit</button>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class Reader extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('crud');
		$this->load->model('RawmaterialM');
		$this->load->library('my_email');

	}
	public function index()
	{

		// $data['data'] = $this->crud->get_records('raw_material1');

		// echo "<pre>";print_r($data); die();

		$this->load->view('reader/list');
	}
	public function insert()
{
	// if ($this->input->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest') {
    //  \
    // } else {

    //     show_404();
    // }
	$data = json_decode(file_get_contents('php://input'), true);
	print_r($data);
	die();
    // Check if it's an AJAX request
    if ($this->input->is_ajax_request()) {
		// Retrieve data from POST request
		$data = json_decode(file_get_contents('php://input'), true);
        $qrCodes = $data['qrCodes'];
        $barcodes = $data['barcodes'];

        // Print the received data for debugging
        echo "Received QR Codes:<br>";
        print_r($qrCodes);
        echo "<br>Received Barcodes:<br>";
        print_r($barcodes);

        // Process your data here, for example:
        foreach ($qrCodes as $qrCode) {
            // Insert or process each QR code
        }

        foreach ($barcodes as $barcode) {
            // Insert or process each barcode
        }

        // Send success response
        $response = array('success' => true, 'message' => 'Data submitted successfully.');
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    } else {
        // If not an AJAX request, redirect or handle accordingly
        show_404();
    }
}

}