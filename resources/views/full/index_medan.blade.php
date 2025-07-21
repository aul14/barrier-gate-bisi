@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @if (Request::is('full_table*'))
        @include('layouts.navbars.auth.topnav', ['title' => 'Barrier Gate Truck Scale'])
    @else
        @include('layouts.navbars.auth.topnav', ['title' => 'Realtime Monitor'])
    @endif

    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-header p-0">
                @if (!Request::is('full_table*'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date & Time </label>
                                        <!--digital clock start-->
                                        <div class="datetime">
                                            <div class="date">
                                                <span id="dayname">Day</span>,
                                                <span id="month">Month</span>
                                                <span id="daynum">00</span>,
                                                <span id="year">Year</span>
                                            </div>
                                            <div class="time">
                                                <span id="hour">00</span>:
                                                <span id="minutes">00</span>:
                                                <span id="seconds">00</span>
                                                <span id="period" class="d-none">AM</span>
                                            </div>
                                        </div>
                                        <!--digital clock end-->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" readonly class="form-control text-center text-cc bg_val"
                                            value="Jembatan Timbang {{ auth()->user()->default_wb === 'WB1' ? 1 : (auth()->user()->default_wb === 'WB2' ? 2 : (auth()->user()->default_wb === 'WB3' ? 3 : 4)) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Search Jembatan Timbang</label>
                                        <div class="col-md-12">
                                            <select name="select_bg" class="form-select select-bg">
                                                <option value="WB1" @selected(auth()->user()->default_wb === 'WB1' ? true : false)>Jembatan Timbang 1
                                                </option>
                                                <option value="WB2" @selected(auth()->user()->default_wb === 'WB2' ? true : false)>Jembatan Timbang 2
                                                </option>
                                                <option value="WB3" @selected(auth()->user()->default_wb === 'WB3' ? true : false)>Jembatan Timbang 3
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->default_wb === 'WB1')
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-sm-12 row-btn-right">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                                data-open_gate="BG1" data-wb="1">Open Gate 1</a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                                data-close_gate="BG1" data-wb="1">Close Gate 1</a>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-sm-12 d-flex justify-content-center p-0 m-0" id="bg-svg">
                                    </div>
                                    <div class="col-lg-3 col-sm-12 row-btn-left">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                                data-open_gate="BG2" data-wb="1">Open Gate 2</a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                                data-close_gate="BG2" data-wb="1">Close Gate 2</a>
                                        @endif
                                    </div>
                                </div>
                            @elseif (auth()->user()->default_wb === 'WB2')
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-sm-12 row-btn-right">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                                data-open_gate="BG2" data-wb="2">Open Gate 2</a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                                data-close_gate="BG2" data-wb="2">Close Gate 2</a>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-sm-12 d-flex justify-content-center p-0 m-0" id="bg-svg">
                                    </div>
                                    <div class="col-lg-3 col-sm-12 row-btn-left">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                                data-open_gate="BG1" data-wb="2">Open Gate 1</a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                                data-close_gate="BG1" data-wb="2">Close Gate 1</a>
                                        @endif
                                    </div>
                                </div>
                            @elseif (auth()->user()->default_wb === 'WB3')
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-sm-12 row-btn-right">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                                data-open_gate="BG2" data-wb="3">Open Gate 2</a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                                data-close_gate="BG2" data-wb="3">Close Gate 2</a>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-sm-12 d-flex justify-content-center p-0 m-0" id="bg-svg">
                                    </div>
                                    <div class="col-lg-3 col-sm-12 row-btn-left">
                                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                                data-open_gate="BG1" data-wb="3">Open Gate 1</a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                                data-close_gate="BG1" data-wb="3">Close Gate 1</a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <select name="type_scenario" class="ts-bg">
                                            <option value="">Search</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <select name="status" class="sts-bg">
                                            <option value="">Search</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <input type="text" placeholder="Search By Plat Nomor" class="form-nopol"
                                            name="plat_nomor">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        @if (Request::is('full_table*'))
                            <table class="table my-table my-tableonly my-table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Orders</th>
                                        <th>Type Scenario</th>
                                        <th>Scales 1 | 3</th>
                                        <th>Scales 2 | 4</th>
                                        <th>Status</th>
                                        <th>Tracking Status</th>
                                    </tr>
                                </thead>
                            </table>
                        @else
                            <table class="table my-table my-tableview my-table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Orders</th>
                                        <th>Type Scenario</th>
                                        <th>Scales 1 | 3</th>
                                        <th>Scales 2 | 4</th>
                                        <th>Status</th>
                                        <th>Tracking Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="wb-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title wb-title text-white" id="staticBackdropLabel">Required Information Form</h5>
                    <a href="javascript:void(0)" class="btn btn-xs btn-danger" data-bs-dismiss="modal">X</a>
                </div>
                <div class="modal-body">
                    <form class="row gx-3 gy-2 align-items-center savewb-form">
                        <input type="hidden" name="open_gate">
                        <input type="hidden" name="wb">
                        <div class="col-sm-3">
                            <label class="visually-hidden" for="plant">Plant</label>
                            <input type="text" class="form-control" id="plant" name="plant" autocomplete="off"
                                placeholder="Plant">
                        </div>
                        <div class="col-sm-3">
                            <label class="visually-hidden" for="sequence">Sequence</label>
                            <input type="text" class="form-control" id="sequence" name="sequence"
                                autocomplete="off" placeholder="Sequence">
                        </div>
                        <div class="col-sm-3">
                            <label class="visually-hidden" for="arrival_date">Arrival Date</label>
                            <input type="text" class="form-control" id="arrival_date" name="arrival_date"
                                autocomplete="off" placeholder="Arrival Date">
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>

    @if (Request::is('full_table*'))
        <script>
            let ws_url = $("input[name=ws_url]").val();
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                wsRealTime();

                let auto;
                $(".btn-pause").click(function(e) {
                    e.preventDefault();
                    $(".btn-pause").hide();
                    $(".btn-play").show();
                    auto = false;
                });

                $(".btn-play").click(function(e) {
                    e.preventDefault();
                    $(".btn-pause").show();
                    $(".btn-play").hide();
                    auto = true;
                });


                $.fn.DataTable.ext.pager.numbers_length = 5;
                let table = $('.my-table').DataTable({
                    processing: false,
                    serverSide: true,
                    searching: false,
                    info: false,
                    ordering: false,
                    paging: true,
                    pageLength: 5,
                    bLengthChange: false,
                    pagingType: 'full_numbers',
                    scrollX: true,
                    scrollY: "85vh",
                    ajax: '{{ route('full_table') }}',
                    oLanguage: {
                        oPaginate: {
                            sNext: '<span class="fas fa-angle-right pgn-1" style="color: #5e72e4"></span>',
                            sPrevious: '<span class="fas fa-angle-left pgn-2" style="color: #5e72e4"></span>',
                            sFirst: '<span class="fas fa-angle-double-left pgn-3" style="color: #5e72e4"></span>',
                            sLast: '<span class="fas fa-angle-double-right pgn-4" style="color: #5e72e4"></span>',
                        }
                    },
                    columns: [{
                            data: 'orders',
                        },
                        {
                            data: 'scenario',
                        },
                        {
                            data: 'scale_1'
                        },
                        {
                            data: 'scale_2'
                        },
                        {
                            data: 'status_bg'
                        },
                        {
                            data: 'track_status'
                        },

                    ],
                    columnDefs: [{
                        defaultContent: "-",
                        targets: "_all"
                    }],
                });

                // Auto next page
                setInterval(function() {
                    var info = table.page.info();
                    var pageNum = (info.page + 1 < info.pages) ? info.page + 1 : 0;
                    table.page(pageNum).draw(false);
                }, 15000);
            });

            async function wsRealTime() {
                let ws = new WebSocket(`${ws_url}/real-time`);

                ws.onopen = function(event) {
                    console.log('Connection Dashboard Real Time Established');
                };

                ws.onmessage = function(e) {
                    try {
                        let data = JSON.parse(e.data);
                        let status = data.status;
                        let wb_condition = data.wb_condition;
                        let direction = data.direction;
                        let truck_no = data.truck_no != null ? data.truck_no.replace(/\s/g, '').split(/(\/[A-Z])?/)
                            .filter(
                                Boolean) : null;
                        let audioFiles = [];
                        let currentAudioIndex = 0;
                        if (data.wb && data.open_gate) {
                            if (status !== 'completed') {
                                if (wb_condition == 'short' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'mundur') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'short' && direction == 'by_pass') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(``);
                                    }
                                }
                            } else if (status === 'completed') {
                                if (wb_condition == 'short' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'mundur') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'short' && direction == 'by_pass') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                }
                            }

                            if (val_bg === `WB${data.wb}`) {
                                playAudio();
                            }

                        }

                        function playAudio() {
                            const audio = new Audio(audioFiles[currentAudioIndex]);
                            // Move to the next audio file in the array
                            currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                            if (currentAudioIndex == 0) {
                                audio.pause();
                                audio.currentTime = 0;
                            } else {
                                if (auto) {
                                    audio.play();
                                } else {
                                    audio.pause();
                                    audio.currentTime = 0;
                                }
                            }

                            // Listen for the 'ended' event to play the next audio
                            audio.addEventListener('ended', playAudio);
                        }
                    } finally {
                        $('.my-table').DataTable().ajax.reload();
                    }
                };

                ws.onerror = function(err) {
                    console.log(err); // Write errors to console
                };

                await new Promise((resolve, reject) => {
                    ws.onclose = function(event) {
                        // connection closed, discard old websocket and create a new one in 5s
                        ws = null;
                        // Attempt to reconnect after a delay (e.g., 5 seconds)
                        setTimeout(() => {
                            console.log('Attempting to reconnect...');
                            resolve
                                (); // Resolve the promise to indicate the close event has been handled
                        }, 5000);
                    };
                });
            }
        </script>
    @else
        <script>
            let val_bg = $('.select-bg').find(":selected").val(),
                apk_name = $("input[name=apk_name]").val(),
                ws_url = $("input[name=ws_url]").val();
            let audioFiles = null;
            let currentAudioIndex = 0;
            let auto;

            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let userDefaultWb = "{{ auth()->user()->default_wb }}";

                if (userDefaultWb === 'WB1') {
                    wsBarrierGate("WB1");
                } else if (userDefaultWb === 'WB2') {
                    wsBarrierGate("WB2");
                } else if (userDefaultWb === 'WB3') {
                    wsBarrierGate("WB3");
                } else {
                    wsBarrierGate("WB4");
                }

                wsRealTime();

                initClock();

                $(document).on("click", ".btn-open-left", function(e) {
                    e.preventDefault();
                    let wb = $(this).data('wb');
                    let open_gate = $(this).data('open_gate');

                    $.ajax({
                        type: "post",
                        url: '{{ route('get_bearier') }}',
                        data: {
                            wb: wb,
                            open_gate: open_gate,
                            cache: false,
                            from: "web-btn",
                        },
                        dataType: "json",
                        success: function(res) {
                            let audioFiles = [];
                            let currentAudioIndex = 0;

                            audioFiles.push(`/audio/open/wb${wb}-${open_gate}.mp3`);
                            audioFiles.push(``);

                            function playAudio() {
                                const audio = new Audio(audioFiles[currentAudioIndex]);
                                // Move to the next audio file in the array
                                currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                                if (currentAudioIndex == 0) {
                                    audio.pause();
                                    audio.currentTime = 0;
                                } else {
                                    if (auto) {
                                        audio.play();
                                    } else {
                                        audio.pause();
                                        audio.currentTime = 0;
                                    }
                                }

                                // Listen for the 'ended' event to play the next audio
                                audio.addEventListener('ended', playAudio);
                            }

                            playAudio();
                            return;
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
                $(document).on("click", ".btn-close-left", function(e) {
                    e.preventDefault();
                    let wb = $(this).data('wb');
                    let close_gate = $(this).data('close_gate');

                    $.ajax({
                        type: "post",
                        url: '{{ route('get_bearier') }}',
                        data: {
                            wb: wb,
                            close_gate: close_gate,
                            cache: false,
                            from: "web-btn",
                        },
                        dataType: "json",
                        success: function(res) {
                            let audioFiles = [];
                            let currentAudioIndex = 0;

                            audioFiles.push(`/audio/close/wb${wb}-${close_gate}.mp3`);
                            audioFiles.push(``);

                            function playAudio() {
                                const audio = new Audio(audioFiles[currentAudioIndex]);
                                // Move to the next audio file in the array
                                currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                                if (currentAudioIndex == 0) {
                                    audio.pause();
                                    audio.currentTime = 0;
                                } else {
                                    if (auto) {
                                        audio.play();
                                    } else {
                                        audio.pause();
                                        audio.currentTime = 0;
                                    }
                                }

                                // Listen for the 'ended' event to play the next audio
                                audio.addEventListener('ended', playAudio);
                            }

                            playAudio();
                            return;
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
                $(document).on("click", ".btn-open-right", function(e) {
                    e.preventDefault();
                    let wb = $(this).data('wb');
                    let open_gate = $(this).data('open_gate');

                    $.ajax({
                        type: "post",
                        url: '{{ route('get_bearier') }}',
                        data: {
                            wb: wb,
                            open_gate: open_gate,
                            cache: false,
                            from: "web-btn",
                        },
                        dataType: "json",
                        success: function(res) {
                            let audioFiles = [];
                            let currentAudioIndex = 0;

                            audioFiles.push(`/audio/open/wb${wb}-${open_gate}.mp3`);
                            audioFiles.push(``);

                            function playAudio() {
                                const audio = new Audio(audioFiles[currentAudioIndex]);
                                // Move to the next audio file in the array
                                currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                                if (currentAudioIndex == 0) {
                                    audio.pause();
                                    audio.currentTime = 0;
                                } else {
                                    if (auto) {
                                        audio.play();
                                    } else {
                                        audio.pause();
                                        audio.currentTime = 0;
                                    }
                                }

                                // Listen for the 'ended' event to play the next audio
                                audio.addEventListener('ended', playAudio);
                            }

                            playAudio();
                            return;
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
                $(document).on("click", ".btn-close-right", function(e) {
                    e.preventDefault();
                    let wb = $(this).data('wb');
                    let close_gate = $(this).data('close_gate');

                    $.ajax({
                        type: "post",
                        url: '{{ route('get_bearier') }}',
                        data: {
                            wb: wb,
                            close_gate: close_gate,
                            cache: false,
                            from: "web-btn",
                        },
                        dataType: "json",
                        success: function(res) {
                            let audioFiles = [];
                            let currentAudioIndex = 0;

                            audioFiles.push(`/audio/close/wb${wb}-${close_gate}.mp3`);
                            audioFiles.push(``);

                            function playAudio() {
                                const audio = new Audio(audioFiles[currentAudioIndex]);
                                // Move to the next audio file in the array
                                currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                                if (currentAudioIndex == 0) {
                                    audio.pause();
                                    audio.currentTime = 0;
                                } else {
                                    if (auto) {
                                        audio.play();
                                    } else {
                                        audio.pause();
                                        audio.currentTime = 0;
                                    }
                                }

                                // Listen for the 'ended' event to play the next audio
                                audio.addEventListener('ended', playAudio);
                            }

                            playAudio();
                            return;
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });

                // SEARCH BY JEMBATAN TIMBANG
                $(".select-bg").change(function(e) {
                    e.preventDefault();
                    let val = $(this).val();
                    val_bg = val;

                    let id_user = "{{ auth()->user()->id }}";
                    let url_user_wb = '{{ route('users.update', ':id') }}';
                    url_user_wb = url_user_wb.replace(':id', `${id_user}`);

                    $.ajax({
                        type: "put",
                        url: url_user_wb,
                        data: {
                            default_wb: val
                        },
                        dataType: "json",
                        success: function(res) {
                            console.log(res.message);
                        }
                    });

                    $(".row-btn-left").html("");
                    $(".row-btn-right").html("");

                    if (val == "WB1") {
                        $(".bg_val").val("Jembatan Timbang 1");
                        $("#bg-svg").html("");
                        $(".row-btn-left").html(`
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')        
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                data-open_gate="BG2" data-wb="1">Open Gate 2</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                data-close_gate="BG2" data-wb="1">Close Gate 2</a>
                        @endif
                                        `);
                        $(".row-btn-right").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')    
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                data-open_gate="BG1" data-wb="1">Open Gate 1</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                data-close_gate="BG1" data-wb="1">Close Gate 1</a>
                         @endif
                                        `);
                        wsBarrierGate("WB1");
                    } else if (val == "WB2") {
                        $(".bg_val").val("Jembatan Timbang 2");
                        $("#bg-svg").html("");
                        $(".row-btn-left").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')      
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                data-open_gate="BG1" data-wb="2">Open Gate 1</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                data-close_gate="BG1" data-wb="2">Close Gate 1</a>
                        @endif
                                        `);
                        $(".row-btn-right").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                data-open_gate="BG2" data-wb="2">Open Gate 2</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                data-close_gate="BG2" data-wb="2">Close Gate 2</a>
                        @endif
                                        `);
                        wsBarrierGate("WB2");
                    } else if (val == "WB3") {
                        $(".bg_val").val("Jembatan Timbang 3");
                        $("#bg-svg").html("");
                        $(".row-btn-left").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')      
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                data-open_gate="BG1" data-wb="3">Open Gate 1</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                data-close_gate="BG1" data-wb="3">Close Gate 1</a>
                        @endif
                                        `);
                        $(".row-btn-right").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                data-open_gate="BG2" data-wb="3">Open Gate 2</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                data-close_gate="BG2" data-wb="3">Close Gate 2</a>
                        @endif
                                        `);
                        wsBarrierGate("WB3");
                    } else if (val == "WB4") {
                        $(".bg_val").val("Jembatan Timbang 4");
                        $("#bg-svg").html("");
                        $(".row-btn-left").html(`
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                data-open_gate="BG1" data-wb="4">Open Gate 1</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                data-close_gate="BG1" data-wb="4">Close Gate 1</a>
                                      
                        @endif 
                                        `);
                        $(".row-btn-right").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                data-open_gate="BG2" data-wb="4">Open Gate 2</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                data-close_gate="BG2" data-wb="4">Close Gate 2</a>
                        @endif
                                        `);
                        wsBarrierGate("WB4");
                    } else if (val == "WB5") {
                        $(".bg_val").val("Jembatan Timbang 5");
                        $("#bg-svg").html("");
                        $(".row-btn-left").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-left"
                                data-open_gate="BG1" data-wb="5">Open Gate 1</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-left"
                                data-close_gate="BG1" data-wb="5">Close Gate 1</a>
                        @endif
                                        `);
                        $(".row-btn-right").html(` 
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'spv')          
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-primary my-3 btn-gate btn-open-right"
                                data-open_gate="BG2" data-wb="5">Open Gate 2</a>
                            <a href="javascript:void(0)"
                                class="btn btn-lg form-control btn-outline-danger btn-gate btn-close-right"
                                data-close_gate="BG2" data-wb="5">Close Gate 2</a>
                        @endif
                                        `);
                        wsBarrierGate("WB5");
                    } else {
                        $(".bg_val").val("Barrier Gate Not Found!");
                        $("#bg-svg").html("");
                        wsBarrierGate(null);
                    }


                });

                $(".btn-pause").click(function(e) {
                    e.preventDefault();
                    $(".btn-pause").hide();
                    $(".btn-play").show();
                    auto = false;
                });

                $(".btn-play").click(function(e) {
                    e.preventDefault();
                    $(".btn-pause").show();
                    $(".btn-play").hide();
                    auto = true;
                });

                let interval = null;
                let type_scenario = "";
                let next_status = "";
                let plat_nomor = "";

                $(document).on("click", ".btn-plat", function(e) {
                    e.preventDefault();
                    let plat = $(this).data('plat');
                    let truck_no = plat != null ? plat.replace(/\s/g, '').split(/(\/[A-Z])?/).filter(Boolean) :
                        null;
                    let audioFiles = [];
                    let currentAudioIndex = 0;

                    if (plat) {
                        if (truck_no.indexOf('/E') !== -1) {
                            audioFiles.push(`/audio/plat-nomor.mp3`);
                            for (let i = 0; i < truck_no.length; i++) {
                                let element = `/audio/${truck_no[i]}.mp3`;
                                // Skip elements containing "/E.mp3"
                                if (element.includes('/E.mp3')) {
                                    continue;
                                }
                                audioFiles.push(element);
                            }
                            audioFiles.push(`/audio/ekor.mp3`);
                            audioFiles.push(``);
                        } else if (truck_no.indexOf('/K') !== -1) {
                            audioFiles.push(`/audio/plat-nomor.mp3`);
                            for (let i = 0; i < truck_no.length; i++) {
                                let element = `/audio/${truck_no[i]}.mp3`;
                                // Skip elements containing "/K.mp3"
                                if (element.includes('/K.mp3')) {
                                    continue;
                                }
                                audioFiles.push(element);
                            }
                            audioFiles.push(`/audio/kepala.mp3`);
                            audioFiles.push(``);
                        } else {
                            audioFiles.push(`/audio/plat-nomor.mp3`);
                            for (let i = 0; i < truck_no.length; i++) {
                                audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                            }
                            audioFiles.push(``);
                        }

                        function playAudio() {
                            const audio = new Audio(audioFiles[currentAudioIndex]);
                            // Move to the next audio file in the array
                            currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                            if (currentAudioIndex == 0) {
                                audio.pause();
                                audio.currentTime = 0;
                            } else {
                                if (auto) {
                                    audio.play();
                                } else {
                                    audio.pause();
                                    audio.currentTime = 0;
                                }
                            }

                            // Listen for the 'ended' event to play the next audio
                            audio.addEventListener('ended', playAudio);
                        }

                        playAudio();
                    }
                });

                $(document).on("click", ".btn-delete-bg", function(e) {
                    e.preventDefault();
                    let plant = $(this).data('plant');
                    let sequence = $(this).data('seq');
                    let arrival_date = $(this).data('date');

                    $.confirm({
                        title: "Confirmation",
                        content: `Are you sure, you will delete the data with plant <strong>${plant}</strong>, sequence <strong>${sequence}</strong> and arrival date <strong>${arrival_date}</strong>?`,
                        theme: 'bootstrap',
                        columnClass: 'medium',
                        typeAnimated: true,
                        buttons: {
                            hapus: {
                                text: 'Submit',
                                btnClass: 'btn-red',
                                action: function() {
                                    $.ajax({
                                        type: "post",
                                        url: '{{ route('api_cpi.delete') }}',
                                        data: {
                                            plant: plant,
                                            sequence: sequence,
                                            arrival_date: arrival_date
                                        },
                                        dataType: "json",
                                        success: function(res) {
                                            if (res.status == 'success') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success!',
                                                    text: res.message,
                                                }).then(function() {
                                                    $('.my-table').DataTable()
                                                        .ajax
                                                        .reload();
                                                });
                                                return;
                                            } else {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Oops...',
                                                    text: res.message,
                                                }).then(function() {
                                                    $('.my-table').DataTable()
                                                        .ajax
                                                        .reload();
                                                });
                                                return;
                                            }
                                        }
                                    });
                                }
                            },
                            close: function() {}
                        }
                    });
                });

                $(document).on("keyup", "input[name=plat_nomor]", function(e) {
                    let val = $(this).val();
                    plat_nomor = val;
                    let url_ts = '{{ route('full_page', ':id') }}';
                    url_ts = url_ts.replace(':id',
                        `?type_scenario=${type_scenario}&next_status=${next_status}&plat_nomor=${plat_nomor}`
                    );
                    $('.my-table').DataTable().ajax.url(url_ts).load();
                });

                $('.ts-bg').change(function(e) {
                    e.preventDefault();
                    let val = $(this).val();
                    type_scenario = val;
                    let url_ts = '{{ route('full_page', ':id') }}';
                    url_ts = url_ts.replace(':id',
                        `?type_scenario=${type_scenario}&next_status=${next_status}&plat_nomor=${plat_nomor}`
                    );
                    $('.my-table').DataTable().ajax.url(url_ts).load();
                });

                $(`.ts-bg`).select2({
                    placeholder: 'Search type scenario',
                    width: "100%",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('get.ts') }}',
                        dataType: 'json',
                        type: 'POST',
                        delay: 0,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.type_scenario.toUpperCase(),
                                        id: item.type_scenario,
                                    }
                                })
                            };
                        },
                        cache: false
                    }
                });

                $('.sts-bg').change(function(e) {
                    e.preventDefault();
                    let val = $(this).val();
                    next_status = val;
                    let url_ts = '{{ route('full_page', ':id') }}';
                    url_ts = url_ts.replace(':id',
                        `?type_scenario=${type_scenario}&next_status=${next_status}&plat_nomor=${plat_nomor}`
                    );
                    $('.my-table').DataTable().ajax.url(url_ts).load();
                });

                $(`.sts-bg`).select2({
                    placeholder: 'Search status',
                    width: "100%",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('get.sts') }}',
                        dataType: 'json',
                        type: 'POST',
                        delay: 0,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.next_status.toUpperCase(),
                                        id: item.next_status,
                                    }
                                })
                            };
                        },
                        cache: false
                    }
                });

                let url_page = '{{ route('full_page', ':id') }}';
                url_page = url_page.replace(':id', `?type_scenario=${type_scenario}&next_status=${next_status}`);

                $.fn.DataTable.ext.pager.numbers_length = 5;
                $('.my-table').DataTable({
                    processing: false,
                    serverSide: true,
                    searching: false,
                    info: false,
                    ordering: false,
                    paging: false,
                    pagingType: 'full_numbers',
                    scrollX: true,
                    ajax: url_page,
                    oLanguage: {
                        oPaginate: {
                            sNext: '<span class="fas fa-angle-right pgn-1" style="color: #5e72e4"></span>',
                            sPrevious: '<span class="fas fa-angle-left pgn-2" style="color: #5e72e4"></span>',
                            sFirst: '<span class="fas fa-angle-double-left pgn-3" style="color: #5e72e4"></span>',
                            sLast: '<span class="fas fa-angle-double-right pgn-4" style="color: #5e72e4"></span>',
                        }
                    },
                    columns: [{
                            data: 'orders',
                        },
                        {
                            data: 'scenario',
                        },
                        {
                            data: 'scale_1'
                        },
                        {
                            data: 'scale_2'
                        },
                        {
                            data: 'status_bg'
                        },
                        {
                            data: 'track_status'
                        },
                        {
                            data: 'action'
                        },

                    ],
                    columnDefs: [{
                        defaultContent: "-",
                        targets: "_all"
                    }],


                });
            });

            function getFieldValue(fieldName, formdata) {
                let field = formdata.find(item => item.name === fieldName);
                return field ? field.value : null;
            }

            function validateFormData(form) {
                const plant = form.find('[name="plant"]').val().trim();
                const sequence = form.find('[name="sequence"]').val().trim();
                const arrivalDate = form.find('[name="arrival_date"]').val().trim();

                if (!plant || !sequence || !arrivalDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please fill in all required fields: Plant, Sequence, and Arrival Date.',
                    });
                    return false;
                }

                return true;
            }

            async function wsRealTime() {
                let ws = new WebSocket(`${ws_url}/real-time`);

                ws.onopen = function(event) {
                    console.log('Connection Dashboard Real Time Established');
                };

                ws.onmessage = function(e) {
                    try {
                        let data = JSON.parse(e.data);
                        let status = data.status;
                        let wb_condition = data.wb_condition;
                        let direction = data.direction;
                        let truck_no = data.truck_no != null ? data.truck_no.replace(/\s/g, '').split(/(\/[A-Z])?/)
                            .filter(
                                Boolean) : null;
                        let audioFiles = [];
                        let currentAudioIndex = 0;
                        if (data.wb && data.open_gate) {
                            if (status !== 'completed') {
                                if (wb_condition == 'short' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'mundur') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'short' && direction == 'by_pass') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(``);
                                    }
                                }
                            } else if (status === 'completed') {
                                if (wb_condition == 'short' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == null) {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/short/wb${data.wb}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'long' && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'manuver') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/manuver.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == null && direction == 'mundur') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/mundur.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else if (wb_condition == 'short' && direction == 'by_pass') {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/lewat.mp3`);
                                        audioFiles.push(``);
                                    }
                                } else {
                                    audioFiles = [];
                                    if (truck_no.indexOf('/E') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/E.mp3"
                                            if (element.includes('/E.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/ekor.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else if (truck_no.indexOf('/K') !== -1) {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            let element = `/audio/${truck_no[i]}.mp3`;
                                            // Skip elements containing "/K.mp3"
                                            if (element.includes('/K.mp3')) {
                                                continue;
                                            }
                                            audioFiles.push(element);
                                        }
                                        audioFiles.push(`/audio/kepala.mp3`);
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    } else {
                                        audioFiles.push(`/audio/plat-nomor.mp3`);
                                        for (let i = 0; i < truck_no.length; i++) {
                                            audioFiles.push(`/audio/${truck_no[i]}.mp3`);
                                        }
                                        audioFiles.push(`/audio/open/wb${data.wb}-${data.open_gate}.mp3`);
                                        audioFiles.push(`/audio/complete.mp3`);
                                        audioFiles.push(``);
                                    }
                                }
                            }

                            if (val_bg === `WB${data.wb}`) {
                                playAudio();
                            }

                        }

                        function playAudio() {
                            const audio = new Audio(audioFiles[currentAudioIndex]);
                            // Move to the next audio file in the array
                            currentAudioIndex = (currentAudioIndex + 1) % audioFiles.length;

                            if (currentAudioIndex == 0) {
                                audio.pause();
                                audio.currentTime = 0;
                            } else {
                                if (auto) {
                                    audio.play();
                                } else {
                                    audio.pause();
                                    audio.currentTime = 0;
                                }
                            }

                            // Listen for the 'ended' event to play the next audio
                            audio.addEventListener('ended', playAudio);
                        }
                    } finally {
                        $('.my-table').DataTable().ajax.reload();
                    }
                };

                ws.onerror = function(err) {
                    console.log(err); // Write errors to console
                };

                await new Promise((resolve, reject) => {
                    ws.onclose = function(event) {
                        // connection closed, discard old websocket and create a new one in 5s
                        ws = null;
                        // Attempt to reconnect after a delay (e.g., 5 seconds)
                        setTimeout(() => {
                            console.log('Attempting to reconnect...');
                            resolve
                                (); // Resolve the promise to indicate the close event has been handled
                        }, 5000);
                    };
                });
            }

            function wsBarrierGate(WB = null) {
                if (WB == null) {
                    return alert('Connection websocket failed!');
                }

                let svgExample, ws = new WebSocket(`${ws_url}/${WB}`);

                ws.onopen = function(event) {
                    console.log('Connection Barrier Gate Established');
                };

                if (WB == 'WB1') {
                    svgExample = "{{ asset('img/svg/barrier-gate-reverse.svg') }}";
                } else {
                    svgExample = "{{ asset('img/svg/barrier-gate.svg') }}";
                }
                scadavisInit({
                    container: 'bg-svg',
                    iframeparams: 'frameborder="0" height="360" width="650"',
                    svgurl: svgExample
                }).then(sv => {
                    sv.zoomTo(2.2);
                    // sv.enableTools(true, true);
                    sv.hideWatermark();
                    // console.log(data);
                    ws.onmessage = function(e) {
                        var data = JSON.parse(e.data);
                        sv.storeValue("@controller", parseFloat(data.controller));
                        sv.storeValue("@BG1Stat", parseFloat(data.bg1stat));
                        sv.storeValue("@Weight", parseFloat(data.weight));
                        sv.storeValue("@BG2Stat", parseFloat(data.bg2stat));
                        sv.storeValue("@Sensor1", parseFloat(data.sensor1));
                        sv.storeValue("@Sensor2", parseFloat(data.sensor2));
                        sv.storeValue("@Sensor3", parseFloat(data.sensor3));
                        sv.storeValue("@Sensor4", parseFloat(data.sensor4));
                        sv.storeValue("@gandeng", parseFloat(data.gandeng));
                        sv.storeValue("@manuver", parseFloat(data.manuver));
                        sv.updateValues();
                    }

                });

                ws.onclose = function(event) {
                    // connection closed, discard old websocket and create a new one in 5s
                    ws = null
                    // Attempt to reconnect after a delay (e.g., 5 seconds)
                    setTimeout(() => {
                        console.log('Attempting to reconnect...');
                        $("#bg-svg").html("");
                        wsBarrierGate(WB);
                    }, 5000);
                    // setTimeout(wsBarrierGate, 5000, WB)
                }

                ws.error = function(err) {
                    console.log(err); // Write errors to console
                }
            }

            function playAudio() {
                const audio = new Audio(audioFiles);
                // Move to the next audio file in the array

                if (auto) {
                    audio.play();
                } else {
                    audio.pause();
                    audio.currentTime = 0;
                }

                // Listen for the 'ended' event to play the next audio
                audio.addEventListener('ended', playAudio);
                audioFiles = null;
            }

            function updateClock() {
                var now = new Date();
                var dname = now.getDay(),
                    mo = now.getMonth(),
                    dnum = now.getDate(),
                    yr = now.getFullYear(),
                    hou = now.getHours(),
                    min = now.getMinutes(),
                    sec = now.getSeconds(),
                    pe = "AM";

                if (hou >= 12) {
                    pe = "PM";
                }
                if (hou == 0) {
                    hou = 12;
                }

                Number.prototype.pad = function(digits) {
                    for (var n = this.toString(); n.length < digits; n = 0 + n);
                    return n;
                }

                var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October",
                    "November", "December"
                ];
                var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds"];
                var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2)];
                for (var i = 0; i < ids.length; i++)
                    document.getElementById(ids[i]).firstChild.nodeValue = values[i];
            }

            function initClock() {
                updateClock();
                window.setInterval("updateClock()", 1);
            }
        </script>
    @endif
@endsection
