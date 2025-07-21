<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Barrier Gate</title>
    <link id="pagestyle" rel="stylesheet" href="{{ public_path('assets/css/bootstrap.min.css') }}" />

    <style>
        body,
        .my-table {
            font-family: 'Times New Roman', Times, sans-serif;
        }

        .my-table {
            page-break-before: avoid;
            /* page-break-after: always; */
        }

        h2 {
            font-size: 18px;
            text-align: center;
        }

        .my-table {
            border-collapse: collapse;
            width: 100%;
        }

        .my-table th {
            border: 1px solid #000;
            padding: 4px 6px;
        }

        .my-table td {
            border: 1px solid #000;
            padding: 3px 4px;
        }

        .my-table tr th {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 1;
        }

        .my-table tr td:nth-child(1) {
            text-align: center;
        }

        .my-table tr td {
            text-align: justify;
            font-size: 14px;
            word-spacing: -2px;
            line-height: 1.1;
            word-break: break-all;
        }
    </style>
</head>

<body>
    <center>
        <h4>Log Barrier Gate</h4>
    </center>

    <table class="my-table ">
        <thead>
            <tr>
                <th>No</th>
                <th>Plant</th>
                <th>Sequence</th>
                <th>Truck Number</th>
                <th>Arrival date</th>
                <th>arrival time </th>
                <th>type scenario</th>
                <th>vendor do</th>
                <th>status</th>
                <th>scalling 1</th>
                <th>scalling 2</th>
                <th>ship to party</th>
                <th>delivery order no</th>
                <th>from storage location</th>
                <th>upto storage location</th>
                <th>Updated at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($log as $key => $val)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $val->plant }}</td>
                    <td>{{ $val->sequence }}</td>
                    <td>{{ $val->truck_no }}</td>
                    <td>{{ $val->arrival_date }}</td>
                    <td>{{ $val->arrival_time }}</td>
                    <td>{{ $val->type_scenario }}</td>
                    <td>{{ $val->vendor_do }}</td>
                    <td>{{ $val->status }}</td>
                    <td>
                        @php
                            $scale_1 = null;
                            if ($val->scaling_date_1 || $val->scaling_time_1 || $val->qty_scaling_1) {
                                $scale_1 .= "
                                    <span class='badge badge-dark'>
                                    $val->scaling_date_1</span> <br>
                                    <span class='badge badge-dark'>
                                    $val->scaling_time_1</span> <br>
                                    <span class='badge badge-dark'>
                                    $val->qty_scaling_1 KG</span>
                                    ";
                            }
                        @endphp
                        {!! $scale_1 !!}
                    </td>
                    <td>
                        @php
                            $scale_2 = null;
                            if ($val->scaling_date_2 || $val->scaling_time_2 || $val->qty_scaling_2) {
                                $scale_2 .= "
                                    <span class='badge badge-dark'>
                                    $val->scaling_date_2</span> <br>
                                    <span class='badge badge-dark'>
                                    $val->scaling_time_2</span> <br>
                                    <span class='badge badge-dark'>
                                    $val->qty_scaling_2 KG</span>
                                    ";
                            }
                        @endphp
                        {!! $scale_2 !!}
                    </td>
                    <td>{{ $val->ship_to_party }}</td>
                    <td>{{ $val->delivery_order_no }}</td>
                    <td>{{ $val->from_storage_location }}</td>
                    <td>{{ $val->upto_storage_location }}</td>
                    <td>{{ !empty($val->updated_at) ? date('d-m-Y H:i', strtotime($val->updated_at)) : null }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
