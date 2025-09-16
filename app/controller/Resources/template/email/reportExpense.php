<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            text-align: center;
        }

        * {
            font-family: 'Helvetica';
        }

        #date {
            display: block;
            text-align: left;
        }

        .content {
            padding: 10px;
        }

        .content>.category {
            border: 1px solid black;
            margin-bottom: 10px;
            padding: 10px;
        }

        .content>.category>.title {
            margin-bottom: 10px;
            display: block;
        }

        .content>.category>table {
            width: 100%;
            border-collapse: collapse;
        }

        .content>.category>table tr:first-child {
            background-color: #2d7bdd;
            color: white;
        }

        .content>.category>table td {
            border: 1px solid black;
            padding: 2px 5px;
        }

        .content>.category>#total {
            display: block;
            text-align: right;
            margin-top: 5px;
            font-size: 20px;
        }

        #stati {
            margin-bottom: 10px;
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .card-stati>table {
            width: 100%;
        }

        .card-stati #chart {
            width: 100px;
        }

        .card-stati #bar-line {
            height: 17px;
            width: 100%;
            background-color: #e5d7d7;
            position: relative;
            border-radius: 10px;
        }

        .card-stati #inside-line {
            height: 100%;
            background-color: #0597ff;
            border-radius: 10px;
        }

        .card-stati #value-line {
            position: absolute;
            top: 0;
            left: 5px;
            color: #463535;
            line-height: 17px;
        }

        #total {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            font-size: 25px;
            font-weight: bold;
            color: #2d7bdd;
        }

        #total td {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1><?= lang('REPORT COSTS') ?></h1>
    <b id="date"><?= lang('From') ?> <?= date('d/m/Y H:i', strtotime($data->infos->create_at)) ?> <?= lang('To') ?> <?= $data->infos->close_at ? date('d/m/Y H:i', strtotime($data->infos->close_at)) : date('d/m/Y H:i') ?></b>
    <div class="content">

        <?php
        use TOOL\Helper\Convert;

         ?>
        <div class="category">
            <table>
                <tr>
                    <td><?= lang('title') ?></td>
                    <td><?= lang('description') ?></td>
                    <td><?= lang('Total') ?></td>
                </tr>
                <?php foreach ($data->items as $item) : ?>
                    <tr>
                        <td><?= $item->title ?></td>
                        <td><?= $item->description ?></td>
                        <td><?= Convert::price($item->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

    <table id="total">
        <tr>
            <td><?= lang('Total') ?>: <?= Convert::price($data->total) ?></td>
        </tr>
    </table>
    
</body>

</html>