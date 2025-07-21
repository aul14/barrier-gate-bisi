@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Log User'])
    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('users.index') }}" class="btn btn-xs btn-danger"><i class="fa fa-arrow-left"></i>
                            Back to
                            User Management</a>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="my-table table my-tablejust my-table-striped table-hover w-100">
                                <thead>
                                    <tr>
                                        <th width='2'>No</th>
                                        <th class="select-filter">Fullname</th>
                                        <th class="select-filter">Is Active</th>
                                        <th class="select-filter">IP Address</th>
                                        <th class="select-filter">Hostname</th>
                                        <th class="select-filter">User Agent</th>
                                        <th class="select-filter">Last Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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

            let id = '{{ $id }}';

            let url_user_log = '{{ route('users.log', ':id') }}';
            url_user_log = url_user_log.replace(':id', `${id}`);

            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: false,
                serverSide: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 150, 200],
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: url_user_log,
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
                        data: 'user.fullname',
                    },
                    {
                        data: 'active',
                    },
                    {
                        data: 'ip_address',
                    },
                    {
                        data: 'hostname',
                    },
                    {
                        data: 'user_agent',
                    },
                    {
                        data: 'last_login',
                    },

                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],


            });
        });
    </script>
@endsection
