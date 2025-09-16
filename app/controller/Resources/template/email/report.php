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
    <h1><?= lang('REPORT') ?></h1>
    <b id="date"><?= lang('From') ?> <?= date('d/m/Y H:i', strtotime($data->daily->create_at)) ?> <?= lang('To') ?> <?= $data->daily->close_at ? date('d/m/Y H:i', strtotime($data->daily->close_at)) : date('d/m/Y H:i') ?></b>
    <div class="content">

        <?php

        use TOOL\Helper\Convert;

        foreach ($data->items as $categoryName => $category) : ?>
            <div class="category">
                <b class="title"><?= $categoryName ?></b>
                <table>
                    <tr>
                        <td><?= lang('Product') ?></td>
                        <td><?= lang('Total orders') ?></td>
                        <td><?= lang('Total') ?></td>
                    </tr>
                    <?php foreach ($category->items as $item) : ?>
                        <tr>
                            <td><?= $item->title ?></td>
                            <td><?= $item->qnt ?></td>
                            <td><?= Convert::price($item->total) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <b id="total"><?= Convert::price($category->total) ?></b>
            </div>
        <?php endforeach; ?>

    </div>

    <table id="stati">
        <tr>
            <td class="card-stati">
                <table>
                    <tr>
                        <td><?= lang('import') ?></td>
                        <td id="chart">
                            <div id="bar-line">
                                <div id="inside-line" style="width: <?= number_format(($data->daily->byImport / $data->daily->totalOrders) * 100, 0) ?>%;"></div>
                                <b id="value-line"><?= number_format(($data->daily->byImport / $data->daily->totalOrders) * 100, 0) ?>%</b>
                            </div>
                        </td>
                    </tr>
                </table>
                <b><?= Convert::price($data->daily->totalImport) ?></b>
            </td>
            <td class="card-stati">
                <table>
                    <tr>
                        <td><?= lang('delivery') ?></td>
                        <td id="chart">
                            <div id="bar-line">
                                <div id="inside-line" style="width: <?= number_format(($data->daily->byDelivery / $data->daily->totalOrders) * 100, 0) ?>%;"></div>
                                <b id="value-line"><?= number_format(($data->daily->byDelivery / $data->daily->totalOrders) * 100, 0) ?>%</b>
                            </div>
                        </td>
                    </tr>
                </table>
                <b><?= Convert::price($data->daily->totalDelivery) ?></b>
            </td>
            <td class="card-stati">
                <table>
                    <tr>
                        <td><?= lang('table') ?></td>
                        <td id="chart">
                            <div id="bar-line">
                                <div id="inside-line" style="width: <?= number_format(($data->daily->byTable / $data->daily->totalOrders) * 100, 0) ?>%;"></div>
                                <b id="value-line"><?= number_format(($data->daily->byTable / $data->daily->totalOrders) * 100, 0) ?>%</b>
                            </div>
                        </td>
                    </tr>
                </table>
                <b><?= Convert::price($data->daily->totalTable) ?></b>
            </td>
        </tr>
    </table>

    <table id="total">
        <tr>
            <td><?= lang('Total orders') ?>: <?= $data->daily->totalOrders ?></td>
            <td><?= lang('Total') ?>: <?= Convert::price($data->total) ?></td>
        </tr>
    </table>
    <!-- user info -->
    <h1><?= lang('USERS REPORT') ?></h1>
    <div class="content">

        <?php

        foreach ($data->users as $user) : ?>
            <div class="category">
                <b class="title"><?= $user->infos->username ?></b>
                <table>
                    <tr>
                        <td><?= lang('Category') ?></td>
                        <td><?= lang('QNT') ?></td>
                        <td><?= lang('Total') ?></td>
                    </tr>
                    <?php foreach ($user->details->data->items as $categoryName => $category) : ?>
                        <tr>
                            <td><?= $categoryName ?></td>
                            <td><?= $category->nbItems?></td>
                            <td><?= Convert::price($category->total) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <b id="total"><?= Convert::price($user->infos->total) ?></b>
            </div>
        <?php endforeach; ?>

    </div>
</body>

</html>