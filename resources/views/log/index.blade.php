@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Log Barrier Gate'])
    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-header p-0">
                <form action="{{ route('log.index') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-2 overflow-auto">
                            <div class="input-group mb-3">
                                <input type="text" name="date_start" value="{{ $date_start }}" placeholder="Start Date"
                                    autocomplete="off" class="daterangepicker-field form-control text-center">
                                <span class="input-group-text"><i class="fa fa-calendar-days"></i></span>
                                <input type="text" name="date_end" value="{{ $date_end }}" placeholder="End Date"
                                    autocomplete="off" class="daterangepicker-field form-control text-center">
                            </div>
                        </div>

                        <div class="col-md-12 my-2">
                            <a href="{{ route('log.index') }}" class="btn btn-md btn-outline-warning">Refresh</a>
                            <button type="submit" class="btn btn-md btn-outline-primary">Search</button>
                            @if (!empty($date_start) || !empty($date_end))
                                <a href="{{ route('log.index', ['download' => 'pdf', 'date_start' => $date_start, 'date_end' => $date_end]) }}"
                                    class="btn btn-md btn-outline-success" target="_blank">Export
                                    to PDF</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table my-table my-tablelog my-table-striped w-100">
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
                                    <th>scalling 3</th>
                                    <th>scalling 4</th>
                                    <th>ship to party</th>
                                    <th>delivery order no</th>
                                    <th>from storage location</th>
                                    <th>upto storage location</th>
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                        </table>
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

            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [50, 100, 150, 200],
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: {
                    type: "get",
                    url: '{{ route('log.index') }}',
                    data: {
                        date_start: '{{ $date_start }}',
                        date_end: '{{ $date_end }}',
                    },
                    dataType: "json",
                },
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fas fa-angle-right pgn-1" style="color: #017CC4"></span>',
                        sPrevious: '<span class="fas fa-angle-left pgn-2" style="color: #017CC4"></span>',
                        sFirst: '<span class="fas fa-angle-double-left pgn-3" style="color: #017CC4"></span>',
                        sLast: '<span class="fas fa-angle-double-right pgn-4" style="color: #017CC4"></span>',
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'plant',
                    },
                    {
                        data: 'sequence',
                    },
                    {
                        data: 'truck_no',
                    },
                    {
                        data: 'arrival_date',
                    },
                    {
                        data: 'arrival_time',
                    },
                    {
                        data: 'type_scenario',
                    },
                    {
                        data: 'vendor_do',
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'scale_1'
                    },
                    {
                        data: 'scale_2'
                    },
                    {
                        data: 'scale_3'
                    },
                    {
                        data: 'scale_4'
                    },
                    {
                        data: 'ship_to_party'
                    },
                    {
                        data: 'delivery_order_no'
                    },
                    {
                        data: 'from_storage_location'
                    },
                    {
                        data: 'upto_storage_location'
                    },
                    {
                        data: 'updated_at'
                    },


                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],


            });

            $("input[name=date_start]").daterangepicker({
                forceUpdate: false,
                single: true,
                timeZone: 'Asia/Jakarta',
                startDate: moment().subtract(1, 'days'),
                periods: ['day', 'week', 'month', 'year'],
                // standalone: true,
                callback: function(start, period) {

                    var title = start.format('YYYY-MM-DD');
                    $(this).val(title)
                }
            });
            $("input[name=date_end]").daterangepicker({
                forceUpdate: false,
                single: true,
                timeZone: 'Asia/Jakarta',
                startDate: moment().subtract(0, 'days'),
                periods: ['day', 'week', 'month', 'year'],
                // standalone: true,
                callback: function(start, period) {

                    var title = start.format('YYYY-MM-DD');
                    $(this).val(title)
                }
            });
        });
    </script>
@endsection
