<?php

// echo "<pre>";
// print_r($elective_subject[0]['elective']); die();?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css1/bootstrap.min.css">
    <script src="<?php echo base_url(); ?>js1/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>js1/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>js1/bootstrap.min.js"></script> -->


    <style>
        body {
            padding: 1px;
            font-family: 'Times New Roman', Times, serif;
        }

        .heading {
            /*  margin: auto; 
*/

            text-align: center;



        }

        .student {
            page-break-inside: avoid;
        }

        .section {
            margin-left: 25px;
        }

        .section-element {
            font-weight: bold;

        }

        .table-head {
            text-align: center;
        }


        /*@page{size: auto; }*/

        tr {

            line-height: 12px;
            font-size: 12px;
            page-break-inside: avoid;

        }
        

        h6 {
            font-size: 12.5px;
        }

        p {
            font-size: 12.5px;
        }

        section {
            font-size: 20px;
        }

        .horizontal-table-container {
            /* display: flex;
        flex-wrap: wrap;
        justify-content: space-between; */
            padding: 0px;
        }
        td{
            padding:0px;
        }

        @media print {

            header,
            footer {
                /* position: fixed; */
                width: 100%;
                background-color: #ccc;
                /* padding: 10px; */
                /* margin-top:15px; */
            }

            header {
                top: 0;
                page-break-before: always;
            }

            footer {
                bottom: 0;
                margin-left: 5%;
            }
            
      
            .print-table {
                margin-left: 5%;
            }

            .header {
                margin-left: 5%;

            }
table input {
    border : none;
}
        }

        table input {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php $i = 0;
    $j = 1;
    for ($x = 0; $x < count($student_list) / 20; $x++) { ?>
        <?php $pg = 0; ?>
        <header>
            <div class="header" style="margin-right: 2%;">
                <div style="margin-top: 1%;">
                    <h6>Center: <strong>IPS Academy,Institute of Engineering &amp Science, Indore(0808)</strong></h6>
                    <h6>Branch:<strong>
                            <? echo $department_name; ?>
                        </strong></h6>
                        <h6 >Practical Exam in:</h6>
                        <h6>Semester:
                        <?php if ($sem[0] == 1) {
                            echo "I Year(I Sem.)";
                        } elseif ($sem[0] == 2) {
                            echo "I Year(II Sem.)";
                        } elseif ($sem[0] == 3) {
                            echo "II Year(III Sem.)";
                        } elseif ($sem[0] == 4) {
                            echo "II Year(IV Sem.)";
                        } elseif ($sem[0] == 5) {
                            echo "III Year(V Sem.)";
                        } elseif ($sem[0] == 6) {
                            echo "III Year(VI Sem.)";
                        } elseif ($sem[0] == 7) {
                            echo "IV Year(VII Sem.)";
                        } elseif ($sem[0] == 8) {
                            echo "IV Year(VIII Sem.)";
                        }
                        ?>
                    </h6>
                    <h6 id="sub" style="text-align: left;margin-left:50%;margin-top: -1.4rem; ">Sub code & sub:
                        <?php echo $subject_name . "/" . $clg_sub_code; ?>
                    </h6>
                    <h6>Date of Practical Examination:</h6>
                    <h6 id="he" style="text-align: left ;margin-left:50%;margin-top: -1.4rem; ">Maximum
                        Marks:&emsp;&emsp;&emsp;Minimum Marks:</h6>

                    <h6>No. due to appear:
                        <?php echo count($student_list); ?>
                    </h6>
                    <h6 id="actual" style="text-align: left;margin-top: -1.4rem; margin-left:50%;">No actually
                        appeared:...........................</h6>
                    <h6>No. of student passed:...........................</h6>
                    <h6 id="percentage" style="text-align: left;margin-top: -1.4rem; margin-left:50%;">Percentage of
                        pass:...........................</h6>
                    <p>Certified that the maximum and minimum pass marks as shown in this sheet are as per scheme of
                        examination of the University. I shall be responsible for any error or omission in it. </p>

                </div>
            </div>


        </header>
        <main>
            <div class="print-table">
                <h2 class="table-head"></h2>
                <div class="table-responsive" style="display: flex;
        justify-content: center;
        align-items: center; flex-direction:column">
                    <?php //$i = 0;
                        //$j = 1;
                        // for ($x = 0; $x < count($student_list) / 5; $x++) { ?>
                    <table class="table table-bordered table-hover table1">
                        <thead>

                            <tr>
                                <th rowspan="2"
                                    style="vertical-align:middle; width: 0%; text-align: center; border:1.5px solid black; ">
                                    S.No.</th>
                                <th rowspan="2"
                                    style="vertical-align:middle; width: 0%; text-align: center; border:1.5px solid black;">
                                    Enrollment No.</th>

                                <th rowspan="2"
                                    style="vertical-align:middle; width: 10%; text-align: center; border:1.5px solid black; ">
                                    Name of
                                    Candidate</th>
                                <th rowspan="2"
                                    style="vertical-align:middle;width:1%;  text-align: center; border:1.5px solid black;">
                                    Present/
                                    Absent
                                </th>
                                <th colspan="2"
                                    style=" vertical-align:middle; width:10%; text-align: center; border:1.5px solid black;">
                                    <center>Marks Alloted</center>
                                </th>
                                <!-- <th rowspan="2"
                                style="vertical-align:middle; width: 0%; text-align: center; border:1.5px solid black;">
                                Roll no.
                            </th> -->
                            </tr>
                            <tr>

                                <th style="width: 5%; text-align:center; border: 1.5px solid black; padding:5px; "
                                    rowspan="2">
                                    In Figures
                                </th>
                                <th style="width: 20%; text-align:center; border: 1.5px solid black; padding:5px; "
                                    rowspan="2">
                                    In Words
                                </th>
                            </tr>



                        </thead>
                        <tbody >
                            <?php
                            for ($k = 0; $k < 20; $k++) {
                                ?>
                                <tr>
                                    <td style="border:1.5px solid black; text-align: center;padding:4px;vertical-align:middle;">
                                        <?php echo $j++; ?>
                                    </td>
                                    <td style="border:1.5px solid black;padding:4px; vertical-align:middle;">
                                        <?php echo $student_list[$i]['enrollment_no']; ?>
                                    </td>
                                    <td style="border:1.5px solid black;padding:4px;vertical-align:middle; ">
                                        <?php echo $student_list[$i]['student_name']; ?>
                                    </td>
                                    <td style="border:1.5px solid black;padding:4px;vertical-align:middle; "></td>

                                    <td style="border:1.5px solid black;padding:4px;vertical-align:middle; ">
                                        <!-- Add a unique ID for each input field -->
                                        <input style="text-align: center;padding:4px; vertical-align:middle;" type="text"  name="marks_infiger"
                                            id="numberInput_<?php echo $i; ?>" class="numberInput">
                                    </td>
                                    <td style="border:1.5px solid black;padding:4px; vertical-align:middle;" align="center"  id="table-body_<?php echo $i; ?>">
                                    
                                        <!-- Add a unique ID for each table cell -->
                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </main>
        <footer>
            <h6>Date</h6><br>
            <h6 style="text-align: right ;margin-right:280px;margin-top: -2.9rem; ">Date</h6><br>
            <h6>Signature of Internal Examiner</h6>
            <h6 style="text-align: right ;margin-right:150px;margin-top: -1.4rem; ">Signature of External Examiner</h6>
            <h6>Full Name...........................</h6>
            <h6 style="text-align: right ;margin-right:170px;margin-top: -1.4rem; ">Full Name...........................
            </h6>
            <h6>Designation...........................</h6>
            <h6 style="text-align: right ;margin-right: 163px;margin-top: -1.4rem; ">Designation...........................
            </h6>
            <h6 style="text-align: right ;margin-top: 0rem;margin-right:170px; ">Affiliation...........................</h6>
        </footer>
        <?php $pg++;
    } ?>
    
    <script>
      
        // Function to convert number to words
        function numberToWords(number) {
            const units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
            const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

            if (number === 0) return 'Zero';

            let result = '';

            if (number >= 1000) {
                result += numberToWords(Math.floor(number / 1000)) + ' Thousand ';
                number %= 1000;
            }

            if (number >= 100) {
                result += units[Math.floor(number / 100)] + ' Hundred ';
                number %= 100;
            }

            if (number >= 20) {
                result += tens[Math.floor(number / 10)] + ' ';
                number %= 10;
            }

            if (number >= 10 && number < 20) {
                result += teens[number - 10] + ' ';
                number = 0;
            }

            if (number > 0) {
                result += units[number];
            }

            return result.trim();
        }

        // Function to update table with number and its word representation
        // Function to update table with number and its word representation
        function updateTable(value, index) {
    const tableBody = document.getElementById(`table-body_${index}`);
    tableBody.innerHTML = ''; // Clear previous table rows

    const row = document.createElement('tr');
    const valueCell = document.createElement('td');
    const wordCell = document.createElement('td');

    // Check if the input is 'ABS'
    if (value.toUpperCase() === 'ABS' || value.toUpperCase() === 'ABSENT') {
        wordCell.textContent = 'Absent';
    } else {
        // Check if the input is a number
        if (!isNaN(value)) {
            const number = parseInt(value);
            valueCell.textContent = isNaN(number) ? '' : number;

            // If the input is a number, display its word representation in the word cell
            wordCell.textContent = isNaN(number) ? '' : numberToWords(number) + " " + "only";
        } else if (['A', 'B', 'S','E','N','T','AB','Absent'].includes(value.toUpperCase()) ) {
            valueCell.textContent = value;
        } else {
            alert("Invalid input! Please enter 'ABS'/'abs' and 'Number'");
            return; 
        }
    }

    wordCell.style.width = '100%';
    wordCell.style.border = 'none';
    wordCell.style.marginTop = '-10px';
    wordCell.style.padding = '0px';

    // row.appendChild(valueCell);
    row.appendChild(wordCell);
    tableBody.appendChild(row);
}

// Listen for changes in the input field
const numberInputs = document.querySelectorAll('.numberInput');
numberInputs.forEach((input, index) => {
    input.addEventListener('input', function () {
        const value = input.value.trim();
        updateTable(value, index);
    });
});



    </script>
</body>

</html>