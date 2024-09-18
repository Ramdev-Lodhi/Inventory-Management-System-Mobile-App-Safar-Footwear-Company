<!DOCTYPE html>
<html lang="en">
<?php //echo "<pre>"; print_r($label); die(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Label</title>
    <link rel="icon" href="<?php echo base_url('images/logo/SafarLogo1.png'); ?>" type="image/png" />
    <link href='https://fonts.googleapis.com/css?family=Libre Barcode 39' rel='stylesheet'>
    <style>
        .label_div {
            padding: 3px;
            border: 1px solid black;
            width: fit-content;
            height: fit-content;
            margin-left: 5px;
            margin-top: 15px;
            display: inline-block;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: 0px;
            text-align: center;
        }

        .label_row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .qrcode {
            height: 100px;
            width: 100px;
        }

        .size_div {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        @media print {

            .label_div {
                page-break-after: always;
                width: calc(33.33% - 4.9px);
                /* Adjusted height */
                /* width:238px; */
                height: 172.8px;
                padding: 6px;
                margin: 1px;
                border:none;
                /* Ensure padding and border are included in the width/height calculation */
                box-sizing: border-box;
            }

            .qrcode {
             
                height: 100px;
                width: 100px;
            }

            body {
                margin: -1px;
            }
        }
    </style>
</head>

<body>

    <?php
     $currentMonth = date('F');
    foreach ($label as $l) { ?>
        <div class="label_div">
            <h4>Article: <?= $l->name ?></h4>
            <h3>Color: <?= $l->color ?></h3>
            <div class="label_row">
                <div>
                    <!-- <h4>M.R.P. Rs. 299/-<br>Per Pair</h4> -->
                    <!-- <h5>(inclusive of all Taxes)</h5> -->
                    <?php if ($l->quality == "second") { ?>
                        <h3>SECOND </h3><?php } else { ?> <h3> &nbsp; </h3><?php } ?> 
                    <h4>Date of Manf. <br> <?= $currentMonth ?> 24</h4>
                    <div class="size_div">
                        <h3>Size:</h3>
                        <h2><?= $l->size ?></h2>
                    </div>
                </div>
                <div class="qrcode_div">
                    <img src="<?= $l->qrcode ?>" alt="qrcode" class='qrcode'>
                </div>
            </div>
        </div>
    <?php } ?>


</body>

</html>