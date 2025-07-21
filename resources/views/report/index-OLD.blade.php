@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Report Barrier Gate'])
    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-header p-0">
                <form class="form-search">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-2 overflow-auto">
                            <div class="input-group mb-3">
                                <input type="text" name="date_start" placeholder="Start Date" autocomplete="off"
                                    class="daterangepicker-field form-control text-center">
                                <span class="input-group-text"><i class="fa fa-calendar-days"></i></span>
                                <input type="text" name="date_end" placeholder="End Date" autocomplete="off"
                                    class="daterangepicker-field form-control text-center">
                            </div>
                        </div>

                        <div class="col-md-12 my-2">
                            <a href="{{ route('report.index') }}" class="btn btn-md btn-outline-warning">Refresh</a>
                            <a href="javascript:void(0)" class="btn btn-md btn-outline-primary btn-search">Search</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-1">
                <div class="row" id="row-content">
                    <div class="col-lg-12">
                        <div class="row report-title">

                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6 col-sm-12">
                                <div id="bc-scale-1" style="height: 370px; width: 100%;"></div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div id="bc-scale-2" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6 col-sm-12">
                                <div id="bc-scale-3" style="height: 370px; width: 100%;"></div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div id="bc-scale-4" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-sm-12 mb-3">
                                <div id="pc-allscenario" style="height: 370px; width: 100%;"></div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div id="pc-scenario" style="height: 370px; width: 100%;"></div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div id="pc-truck" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="tablelog overflow-auto"></div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="tabledb overflow-auto"></div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="tabletrack overflow-auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".btn-search").click(function(e) {
                e.preventDefault();
                let date_start = $(".form-search input[name=date_start]").val();
                let date_end = $(".form-search input[name=date_end]").val();

                if (date_start.trim() === '') {
                    alert('Date start cannot be empty!');
                    return
                }

                if (date_end.trim() === '') {
                    alert('Date end cannot be empty!');
                    return
                }

                dataReport(date_start, date_end);
            });

            $(document).on("click", ".btn-hide-tracking", function(e) {
                $('.tabletrack').empty();
            });

            $(document).on("click", ".btn-hide-db", function(e) {
                $('.tabledb').empty();
            });

            $(document).on("click", ".btn-tracking", function(e) {
                let arrival_date = $(this).data('arrival_date'),
                    plant = $(this).data('plant'),
                    sequence = $(this).data('sequence');

                $.ajax({
                    type: "post",
                    url: '{{ route('get.detail.tracking') }}',
                    data: {
                        plant: plant,
                        arrival_date: arrival_date,
                        sequence: sequence,
                    },
                    dataType: "json",
                    success: function(res) {
                        const tableTrack = $('.tabletrack');
                        if (res.length > 0) {
                            const resultTable = $(
                                `<table class="table my-table my-tablelog my-table-striped w-100"></table>`
                            );

                            resultTable.append(`
                                    <thead>
                                        <tr>
                                            <th style="width: 2% !important;">No</th>
                                            <th style="width: 18% !important;">Status</th>
                                            <th style="width: 80% !important;">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            `);

                            const tableBody = resultTable.find('tbody');
                            $.each(res, function(key, val) {
                                const options = {
                                    timeZone: 'Asia/Jakarta',
                                    hour12: false,
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                };
                                const createdAt = new Date(val['created_at'])
                                    .toLocaleString('en-US', options);

                                tableBody.append(`
                                    <tr>
                                        <td>${key + 1}</td>
                                        <td>${val['status']}</td>
                                        <td>${createdAt}</td>
                                    </tr>
                                `);
                            });

                            tableTrack.empty().append(
                                `<h5 class="float-start">Detail Tracking Status. Plant ${plant}, Sequence ${sequence}, Arrival Date ${arrival_date}</h5>
                                <a href="javascript:void(0)" class="btn btn-md btn-danger float-end btn-hide-tracking"><i class="fa fa-close"></i></a>
                                `
                            ).append(resultTable);
                        } else {
                            tableTrack.empty();
                        }

                    }
                });
            });

            $(document).on("click", ".btn-in", function(e) {
                let type_scenario = $(this).data('type_scenario'),
                    arrival_date = $(this).data('arrival_date');

                $.ajax({
                    type: "post",
                    url: '{{ route('get.detail.barrier') }}',
                    data: {
                        type_scenario: type_scenario,
                        arrival_date: arrival_date,
                    },
                    dataType: "json",
                    success: function(res) {
                        const tableDb = $('.tabledb');
                        if (res.length > 0) {
                            const resultTable = $(
                                `<table class="table my-table my-tablelog my-table-striped w-100"></table>`
                            );

                            resultTable.append(`
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Plant</th>
                                            <th>Sequence</th>
                                            <th>Type Scenario</th>
                                            <th>Scale 1</th>
                                            <th>Scale 2</th>
                                            <th>Scale 3</th>
                                            <th>Scale 4</th>
                                            <th style="width: 5%;">Created At</th>
                                            <th style="width: 2%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            `);
                            const tableBody = resultTable.find('tbody');
                            $.each(res, function(key, val) {
                                const options = {
                                    timeZone: 'Asia/Jakarta',
                                    hour12: false,
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                };
                                const createdAt = new Date(val['created_at'])
                                    .toLocaleString('en-US', options);

                                tableBody.append(`
                                    <tr>
                                        <td>${key + 1}</td>
                                        <td>${val['plant']}</td>
                                        <td>${val['sequence']}</td>
                                        <td>${val['type_scenario']}</td>
                                        <td>
                                            ${(val['scaling_date_1'] && val['scaling_time_1'] && val['qty_scaling_1']) ? 
                                            `${val['scaling_date_1']} <br> ${val['scaling_time_1']} <br> ${val['qty_scaling_1']} KG` : ''}    
                                        </td>
                                        <td>
                                            ${(val['scaling_date_2'] && val['scaling_time_2'] && val['qty_scaling_2']) ? 
                                            `${val['scaling_date_2']} <br> ${val['scaling_time_2']} <br>  ${val['qty_scaling_2']} KG` : ''}    
                                        </td>
                                        <td>
                                            ${(val['scaling_date_3'] && val['scaling_time_3'] && val['qty_scaling_3']) ? 
                                            `${val['scaling_date_3']} <br> ${val['scaling_time_3']} <br> ${val['qty_scaling_3']} KG` : ''}
                                               
                                        </td>
                                        <td>
                                            ${(val['scaling_date_4'] && val['scaling_time_4'] && val['qty_scaling_4']) ? 
                                            `${val['scaling_date_4']} <br> ${val['scaling_time_4']} <br> ${val['qty_scaling_4']} KG` : ''}    
                                        </td>
                                        <td>${createdAt}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-xs btn-primary btn-tracking" data-plant="${val['plant']}" data-sequence="${val['sequence']}" data-arrival_date="${val['arrival_date']}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                `);
                            });

                            tableDb.empty().append(
                                `<h5 class="float-start">Detail Inbounds. Arrival Date ${arrival_date}</h5>
                                <a href="javascript:void(0)" class="btn btn-md btn-danger float-end btn-hide-db"><i class="fa fa-close"></i></a>
                                `
                            ).append(resultTable);
                        } else {
                            tableDb.empty();
                        }
                    }
                });
            });

            $(document).on("click", ".btn-out", function(e) {
                let type_scenario = $(this).data('type_scenario'),
                    arrival_date = $(this).data('arrival_date');

                $.ajax({
                    type: "post",
                    url: '{{ route('get.detail.barrier') }}',
                    data: {
                        type_scenario: type_scenario,
                        arrival_date: arrival_date,
                    },
                    dataType: "json",
                    success: function(res) {
                        const tableDb = $('.tabledb');
                        if (res.length > 0) {
                            const resultTable = $(
                                `<table class="table my-table my-tablelog my-table-striped w-100"></table>`
                            );

                            resultTable.append(`
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Plant</th>
                                            <th>Sequence</th>
                                            <th>Type Scenario</th>
                                            <th>Scale 1</th>
                                            <th>Scale 2</th>
                                            <th>Scale 3</th>
                                            <th>Scale 4</th>
                                            <th style="width: 5%;">Created At</th>
                                            <th style="width: 2%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            `);
                            const tableBody = resultTable.find('tbody');
                            $.each(res, function(key, val) {
                                const options = {
                                    timeZone: 'Asia/Jakarta',
                                    hour12: false,
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                };
                                const createdAt = new Date(val['created_at'])
                                    .toLocaleString('en-US', options);

                                tableBody.append(`
                                    <tr>
                                        <td>${key + 1}</td>
                                        <td>${val['plant']}</td>
                                        <td>${val['sequence']}</td>
                                        <td>${val['type_scenario']}</td>
                                        <td>
                                            ${(val['scaling_date_1'] && val['scaling_time_1'] && val['qty_scaling_1']) ? 
                                            `${val['scaling_date_1']} <br> ${val['scaling_time_1']} <br> ${val['qty_scaling_1']} KG` : ''}    
                                        </td>
                                        <td>
                                            ${(val['scaling_date_2'] && val['scaling_time_2'] && val['qty_scaling_2']) ? 
                                            `${val['scaling_date_2']} <br> ${val['scaling_time_2']} <br>  ${val['qty_scaling_2']} KG` : ''}    
                                        </td>
                                        <td>
                                            ${(val['scaling_date_3'] && val['scaling_time_3'] && val['qty_scaling_3']) ? 
                                            `${val['scaling_date_3']} <br> ${val['scaling_time_3']} <br> ${val['qty_scaling_3']} KG` : ''}
                                               
                                        </td>
                                        <td>
                                            ${(val['scaling_date_4'] && val['scaling_time_4'] && val['qty_scaling_4']) ? 
                                            `${val['scaling_date_4']} <br> ${val['scaling_time_4']} <br> ${val['qty_scaling_4']} KG` : ''}    
                                        </td>
                                        <td>${createdAt}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-xs btn-primary btn-tracking" data-plant="${val['plant']}" data-sequence="${val['sequence']}" data-arrival_date="${val['arrival_date']}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                `);
                            });

                            tableDb.empty().append(
                                `<h5 class="float-start">Detail Outbounds. Arrival Date ${arrival_date}</h5>
                                <a href="javascript:void(0)" class="btn btn-md btn-danger float-end btn-hide-db"><i class="fa fa-close"></i></a>
                                `
                            ).append(resultTable);
                        } else {
                            tableDb.empty();
                        }
                    }
                });
            });
            $(document).on("click", ".btn-oth", function(e) {
                let type_scenario = $(this).data('type_scenario'),
                    arrival_date = $(this).data('arrival_date');

                $.ajax({
                    type: "post",
                    url: '{{ route('get.detail.barrier') }}',
                    data: {
                        type_scenario: type_scenario,
                        arrival_date: arrival_date,
                    },
                    dataType: "json",
                    success: function(res) {
                        const tableDb = $('.tabledb');
                        if (res.length > 0) {
                            const resultTable = $(
                                `<table class="table my-table my-tablelog my-table-striped w-100"></table>`
                            );

                            resultTable.append(`
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Plant</th>
                                            <th>Sequence</th>
                                            <th>Type Scenario</th>
                                            <th>Scale 1</th>
                                            <th>Scale 2</th>
                                            <th>Scale 3</th>
                                            <th>Scale 4</th>
                                            <th style="width: 5%;">Created At</th>
                                            <th style="width: 2%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            `);
                            const tableBody = resultTable.find('tbody');
                            $.each(res, function(key, val) {
                                const options = {
                                    timeZone: 'Asia/Jakarta',
                                    hour12: false,
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                };
                                const createdAt = new Date(val['created_at'])
                                    .toLocaleString('en-US', options);

                                tableBody.append(`
                                    <tr>
                                        <td>${key + 1}</td>
                                        <td>${val['plant']}</td>
                                        <td>${val['sequence']}</td>
                                        <td>${val['type_scenario']}</td>
                                        <td>
                                            ${(val['scaling_date_1'] && val['scaling_time_1'] && val['qty_scaling_1']) ? 
                                            `${val['scaling_date_1']} <br> ${val['scaling_time_1']} <br> ${val['qty_scaling_1']} KG` : ''}    
                                        </td>
                                        <td>
                                            ${(val['scaling_date_2'] && val['scaling_time_2'] && val['qty_scaling_2']) ? 
                                            `${val['scaling_date_2']} <br> ${val['scaling_time_2']} <br>  ${val['qty_scaling_2']} KG` : ''}    
                                        </td>
                                        <td>
                                            ${(val['scaling_date_3'] && val['scaling_time_3'] && val['qty_scaling_3']) ? 
                                            `${val['scaling_date_3']} <br> ${val['scaling_time_3']} <br> ${val['qty_scaling_3']} KG` : ''}
                                               
                                        </td>
                                        <td>
                                            ${(val['scaling_date_4'] && val['scaling_time_4'] && val['qty_scaling_4']) ? 
                                            `${val['scaling_date_4']} <br> ${val['scaling_time_4']} <br> ${val['qty_scaling_4']} KG` : ''}    
                                        </td>
                                        <td>${createdAt}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-xs btn-primary btn-tracking" data-plant="${val['plant']}" data-sequence="${val['sequence']}" data-arrival_date="${val['arrival_date']}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                `);
                            });
                            tableDb.empty().append(
                                `<h5 class="float-start">Detail Others. Arrival Date ${arrival_date}</h5>
                                <a href="javascript:void(0)" class="btn btn-md btn-danger float-end btn-hide-db"><i class="fa fa-close"></i></a>
                                `
                            ).append(resultTable);
                        } else {
                            tableDb.empty();
                        }
                    }
                });
            });

        });

        async function dataReport(date_start, date_end) {
            const tableLog = $('.tablelog'),
                pieData = [],
                barData1 = [],
                barData2 = [],
                barData3 = [],
                barData4 = [],
                arivalDateCharts = [];
            let res = [],
                barYAxisData = [];
            try {
                $('.ajax-loader').css("visibility", "visible");

                const response = await fetch('{{ route('get.report') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        date_start: date_start,
                        date_end: date_end,
                        _token: '{{ csrf_token() }}'
                    }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                res = await response.json();

                if (res[0].length > 0) {
                    // Create the entire result table with the specified class and append it to the tableLog div
                    $(".report-title").empty().html('<h2 class="text-center">Report Barrier Gate</h2>');
                    const resultTable = $(
                        '<table class="table my-table my-tablelog my-table-striped w-100"></table>'
                    );
                    resultTable.append(`
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Arrival Date</th>
                                <th rowspan="2">Inbound</th>
                                <th rowspan="2">Outbound</th>
                                <th rowspan="2">Other</th>
                                <th colspan="3">WB1 (Open Gate)</th>
                                <th colspan="3">WB2 (Open Gate)</th>
                                <th colspan="3">WB3 (Open Gate)</th>
                                <th colspan="3">WB4 (Open Gate)</th>
                            </tr>
                            <tr>
                                <th>1</th>
                                <th>2</th>
                                <th>1 & 2</th>
                                <th>1</th>
                                <th>2</th>
                                <th>1 & 2</th>
                                <th>1</th>
                                <th>2</th>
                                <th>1 & 2</th>
                                <th>1</th>
                                <th>2</th>
                                <th>1 & 2</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    `);

                    const tableBody = resultTable.find('tbody');
                    let sumIn = 0,
                        sumOut = 0,
                        sumOth = 0,
                        sumGate1_1 = 0,
                        sumGate1_2 = 0,
                        sumGate1_12 = 0,
                        sumGate2_1 = 0,
                        sumGate2_2 = 0,
                        sumGate2_12 = 0,
                        sumGate3_1 = 0,
                        sumGate3_2 = 0,
                        sumGate3_12 = 0,
                        sumGate4_1 = 0,
                        sumGate4_2 = 0,
                        sumGate4_12 = 0,
                        count_gate_1_1 = 0,
                        count_gate_1_2 = 0,
                        count_gate_1_12 = 0,
                        count_gate_1_1_SAP = 0,
                        count_gate_1_1_WEB = 0,
                        count_gate_1_2_SAP = 0,
                        count_gate_1_2_WEB = 0,
                        count_gate_2_1 = 0,
                        count_gate_2_2 = 0,
                        count_gate_2_12 = 0,
                        count_gate_2_1_SAP = 0,
                        count_gate_2_1_WEB = 0,
                        count_gate_2_2_SAP = 0,
                        count_gate_2_2_WEB = 0,
                        count_gate_3_1 = 0,
                        count_gate_3_2 = 0,
                        count_gate_3_12 = 0,
                        count_gate_3_1_SAP = 0,
                        count_gate_3_1_WEB = 0,
                        count_gate_3_2_SAP = 0,
                        count_gate_3_2_WEB = 0,
                        count_gate_4_1 = 0,
                        count_gate_4_2 = 0,
                        count_gate_4_12 = 0,
                        count_gate_4_1_SAP = 0,
                        count_gate_4_1_WEB = 0,
                        count_gate_4_2_SAP = 0,
                        count_gate_4_2_WEB = 0;

                    // Iterate through the result and append rows to the table body
                    $.each(res[0], function(key, val) {
                        count_gate_1_1 = val['count_gate_1_1_sap'] + val['count_gate_1_1_web'];
                        count_gate_1_2 = val['count_gate_1_2_sap'] + val['count_gate_1_2_web'];
                        count_gate_1_12 = val['count_gate_1_12'];
                        count_gate_2_1 = val['count_gate_2_1_sap'] + val['count_gate_2_1_web'];
                        count_gate_2_2 = val['count_gate_2_2_sap'] + val['count_gate_2_2_web'];
                        count_gate_2_12 = val['count_gate_2_12'];
                        count_gate_3_1 = val['count_gate_3_1_sap'] + val['count_gate_3_1_web'];
                        count_gate_3_2 = val['count_gate_3_2_sap'] + val['count_gate_3_2_web'];
                        count_gate_3_12 = val['count_gate_3_12'];
                        count_gate_4_1 = val['count_gate_4_1_sap'] + val['count_gate_4_1_web'];
                        count_gate_4_2 = val['count_gate_4_2_sap'] + val['count_gate_4_2_web'];
                        count_gate_4_12 = val['count_gate_4_12'];

                        arivalDateCharts.push(val['arrival_date']);

                        tableBody.append(`
                            <tr>
                                <td>${key + 1}</td>
                                <td>${val['arrival_date']}</td>
                                <td class="text-end"><a href="javascript:void(0)" data-type_scenario="inbound" data-arrival_date="${val['arrival_date']}" class="btn-in">${numberFormat(val['count_inbounds'])}</a> </td>
                                <td class="text-end"><a href="javascript:void(0)" data-type_scenario="outbound" data-arrival_date="${val['arrival_date']}" class="btn-out">${numberFormat(val['count_outbounds'])}</a> </td>
                                <td class="text-end"><a href="javascript:void(0)" data-type_scenario="others" data-arrival_date="${val['arrival_date']}" class="btn-oth">${numberFormat(val['count_others'])}</a> </td>
                                <td class="text-end">${numberFormat(count_gate_1_1)}</td>
                                <td class="text-end">${numberFormat(count_gate_1_2)}</td>
                                <td class="text-end">${numberFormat(count_gate_1_12)}</td>
                                <td class="text-end">${numberFormat(count_gate_2_1)}</td>
                                <td class="text-end">${numberFormat(count_gate_2_2)}</td>
                                <td class="text-end">${numberFormat(count_gate_2_12)}</td>
                                <td class="text-end">${numberFormat(count_gate_3_1)}</td>
                                <td class="text-end">${numberFormat(count_gate_3_2)}</td>
                                <td class="text-end">${numberFormat(count_gate_3_12)}</td>
                                <td class="text-end">${numberFormat(count_gate_4_1)}</td>
                                <td class="text-end">${numberFormat(count_gate_4_2)}</td>
                                <td class="text-end">${numberFormat(count_gate_4_12)}</td>
                            </tr>
                        `);

                        // Calculate sums
                        sumIn += val['count_inbounds'];
                        sumOut += val['count_outbounds'];
                        sumOth += val['count_others'];
                        count_gate_1_1_SAP += val['count_gate_1_1_sap'];
                        count_gate_1_1_WEB += val['count_gate_1_1_web'];
                        count_gate_1_2_SAP += val['count_gate_1_2_sap'];
                        count_gate_1_2_WEB += val['count_gate_1_2_web'];
                        count_gate_2_1_SAP += val['count_gate_2_1_sap'];
                        count_gate_2_1_WEB += val['count_gate_2_1_web'];
                        count_gate_2_2_SAP += val['count_gate_2_2_sap'];
                        count_gate_2_2_WEB += val['count_gate_2_2_web'];
                        count_gate_3_1_SAP += val['count_gate_3_1_sap'];
                        count_gate_3_1_WEB += val['count_gate_3_1_web'];
                        count_gate_3_2_SAP += val['count_gate_3_2_sap'];
                        count_gate_3_2_WEB += val['count_gate_3_2_web'];
                        count_gate_4_1_SAP += val['count_gate_4_1_sap'];
                        count_gate_4_1_WEB += val['count_gate_4_1_web'];
                        count_gate_4_2_SAP += val['count_gate_4_2_sap'];
                        count_gate_4_2_WEB += val['count_gate_4_2_web'];
                        sumGate1_1 += count_gate_1_1;
                        sumGate1_2 += count_gate_1_2;
                        sumGate1_12 += count_gate_1_12;
                        sumGate2_1 += count_gate_2_1;
                        sumGate2_2 += count_gate_2_2;
                        sumGate2_12 += count_gate_2_12;
                        sumGate3_1 += count_gate_3_1;
                        sumGate3_2 += count_gate_3_2;
                        sumGate3_12 += count_gate_3_12;
                        sumGate4_1 += count_gate_4_1;
                        sumGate4_2 += count_gate_4_2;
                        sumGate4_12 += count_gate_4_12;
                    });

                    // Calculate and append total row
                    const totalRow = `
                            <tr>
                                <td colspan="2" class="text-center"><strong>Total</strong></td>
                                <td class="text-end">${numberFormat(sumIn)}</td>
                                <td class="text-end">${numberFormat(sumOut)}</td>
                                <td class="text-end">${numberFormat(sumOth)}</td>
                                <td class="text-end">${numberFormat(sumGate1_1)}</td>
                                <td class="text-end">${numberFormat(sumGate1_2)}</td>
                                <td class="text-end">${numberFormat(sumGate1_12)}</td>
                                <td class="text-end">${numberFormat(sumGate2_1)}</td>
                                <td class="text-end">${numberFormat(sumGate2_2)}</td>
                                <td class="text-end">${numberFormat(sumGate2_12)}</td>
                                <td class="text-end">${numberFormat(sumGate3_1)}</td>
                                <td class="text-end">${numberFormat(sumGate3_2)}</td>
                                <td class="text-end">${numberFormat(sumGate3_12)}</td>
                                <td class="text-end">${numberFormat(sumGate4_1)}</td>
                                <td class="text-end">${numberFormat(sumGate4_2)}</td>
                                <td class="text-end">${numberFormat(sumGate4_12)}</td>
                            </tr>
                    `;
                    tableBody.append(totalRow);

                    // Append the entire result table to the tableLog div
                    tableLog.empty().append(resultTable);

                    pieData.push({
                        value: sumIn,
                        name: 'Inbounds'
                    }, {
                        value: sumOut,
                        name: 'Outbounds'
                    }, {
                        value: sumOth,
                        name: 'Others'
                    }, );

                    barData1.push({
                        name: 'Open gate 1 by SAP',
                        value: count_gate_1_1_SAP
                    }, {
                        name: 'Open gate 1 by Manual',
                        value: count_gate_1_1_WEB
                    }, {
                        name: 'Open gate 2 by SAP',
                        value: count_gate_1_2_SAP
                    }, {
                        name: 'Open gate 2 by Manual',
                        value: count_gate_1_2_WEB
                    }, {
                        name: 'Open gate 1 & 2',
                        value: sumGate1_12
                    });

                    barData2.push({
                        name: 'Open gate 1 by SAP',
                        value: count_gate_2_1_SAP
                    }, {
                        name: 'Open gate 1 by Manual',
                        value: count_gate_2_1_WEB
                    }, {
                        name: 'Open gate 2 by SAP',
                        value: count_gate_2_2_SAP
                    }, {
                        name: 'Open gate 2 by Manual',
                        value: count_gate_2_2_WEB
                    }, {
                        name: 'Open gate 1 & 2',
                        value: sumGate2_12
                    });

                    barData3.push({
                        name: 'Open gate 1 by SAP',
                        value: count_gate_3_1_SAP
                    }, {
                        name: 'Open gate 1 by Manual',
                        value: count_gate_3_1_WEB
                    }, {
                        name: 'Open gate 2 by SAP',
                        value: count_gate_3_2_SAP
                    }, {
                        name: 'Open gate 2 by Manual',
                        value: count_gate_3_2_WEB
                    }, {
                        name: 'Open gate 1 & 2',
                        value: sumGate3_12
                    });

                    barData4.push({
                        name: 'Open gate 1 by SAP',
                        value: count_gate_4_1_SAP
                    }, {
                        name: 'Open gate 1 by Manual',
                        value: count_gate_4_1_WEB
                    }, {
                        name: 'Open gate 2 by SAP',
                        value: count_gate_4_2_SAP
                    }, {
                        name: 'Open gate 2 by Manual',
                        value: count_gate_4_2_WEB
                    }, {
                        name: 'Open gate 1 & 2',
                        value: sumGate4_12
                    });


                    $.each(res[1], function(index, item) {
                        if (item.name === null) {
                            item.name = 'Undefined';
                        }
                    });
                    pieCharts('pc-scenario', 'Type Scenario', pieData);

                    pieCharts('pc-truck', 'Type Truck', res[1]);

                    pieCharts('pc-allscenario', 'All TypeScenario', res[2]);

                    pieCharts('bc-scale-1', 'Summary WB 1', barData1);
                    pieCharts('bc-scale-2', 'Summary WB 2', barData2);
                    pieCharts('bc-scale-3', 'Summary WB 3', barData3);
                    pieCharts('bc-scale-4', 'Summary WB 4', barData4);
                } else {
                    // Display "Data Not Found" message in the tableLog div
                    tableLog.html(`
                        <p class="text-center">Data Not Found</p>
                    `);
                }
            } catch (error) {
                console.error('An error occurred:', error);
            } finally {
                $('.ajax-loader').css("visibility", "hidden");
            }
        }

        function numberFormat(number) {
            return Number(number).toLocaleString('en-US');
        }

        function pieCharts(chartTitle, chartText, pieData) {
            let chartPie = document.getElementById(chartTitle);
            let myChart = echarts.init(chartPie);
            let option;

            option = {
                title: {
                    text: chartText,
                    left: 'center',
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },
                legend: {
                    top: 'bottom'
                },
                series: [{
                    name: chartText,
                    type: 'pie',
                    radius: ['45%', '60%'],
                    labelLine: {
                        length: 30
                    },
                    label: {
                        formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                        backgroundColor: '#F6F8FC',
                        borderColor: '#8C8D8E',
                        borderWidth: 1,
                        borderRadius: 4,
                        rich: {
                            a: {
                                color: '#6E7079',
                                lineHeight: 22,
                                align: 'center'
                            },
                            hr: {
                                borderColor: '#8C8D8E',
                                width: '100%',
                                borderWidth: 1,
                                height: 0
                            },
                            b: {
                                color: '#4C5058',
                                fontSize: 14,
                                fontWeight: 'bold',
                                lineHeight: 33
                            },
                            per: {
                                color: '#fff',
                                backgroundColor: '#4C5058',
                                padding: [3, 4],
                                borderRadius: 4
                            }
                        }
                    },
                    data: pieData
                }]
            };

            option && myChart.setOption(option);
            $(window).on('resize', function() {
                if (myChart != null && myChart != undefined) {
                    myChart.resize();
                }
            });
        }

        function barChartsScale(title, xAxisData, seriesData, chartDomID) {
            let chartDom = document.getElementById(chartDomID);
            let myChart = echarts.init(chartDom);
            let option;

            option = {
                title: {
                    text: title,
                    left: 'center',

                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    top: 'bottom',
                },
                xAxis: [{
                    type: 'category',
                    axisTick: {
                        show: false
                    },
                    data: xAxisData
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: seriesData
            };

            option && myChart.setOption(option);
            $(window).on('resize', function() {
                if (myChart != null && myChart != undefined) {
                    myChart.resize();
                }
            });
        }
    </script>
@endsection
