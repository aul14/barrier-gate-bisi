@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Log API SAP Barrier Gate'])
    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-header p-0">
                <form action="{{ route('log_sap.index') }}" method="get">
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
                            <a href="{{ route('log_sap.index') }}" class="btn btn-md btn-outline-warning">Refresh</a>
                            <button type="submit" class="btn btn-md btn-outline-primary">Search</button>

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
                                    <th>Created At</th>
                                    <th>URL</th>
                                    <th>JSON From SAP</th>
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
                processing: false,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [50, 100, 150, 200],
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: {
                    type: "get",
                    url: '{{ route('log_sap.index') }}',
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
                        data: 'created_at',
                    },
                    {
                        data: 'url',
                    },
                    {
                        data: 'json_sap',
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
