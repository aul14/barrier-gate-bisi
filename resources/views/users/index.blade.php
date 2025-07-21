@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Users Management'])
    <div class="row mt-1 px-1">
        <div class="card">
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                        <th width="2px">Action</th>
                                        <th>No</th>
                                        <th class="select-filter">Fullname</th>
                                        <th class="select-filter">Username</th>
                                        <th class="select-filter">Email</th>
                                        <th class="select-filter">Role</th>
                                        <th class="select-filter">Default Jembatan Timbang</th>
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

            $(document).on("click", ".btn-edit-user", function(e) {
                e.preventDefault();
                let href = $(this).data('href');
                let id = $(this).data('id');

                let url_user_show = '{{ route('users.show', ':id') }}';
                url_user_show = url_user_show.replace(':id', `${id}`);


                $('#modal-form').modal('show');
                $(".user-title").html('Form Edit User');

                $.ajax({
                    type: "get",
                    url: url_user_show,
                    data: {},
                    dataType: "json",
                    success: function(res) {
                        $("#modal-form input[name=fullname]").val(res.fullname);
                        $("#modal-form input[name=username]").val(res.username);
                        $("#modal-form input[name=email]").val(res.email);
                        $("#modal-form select[name=role]").val(res.role).change();
                        $("#modal-form select[name=default_wb]").val(res.default_wb).change();
                    }
                });

                $('.save-form').safeform({
                    timeout: 2000,
                    submit: function(e) {
                        e.preventDefault();
                        // put here validation and ajax stuff..
                        let formdata = $(this).serializeArray();
                        e.preventDefault();
                        $.ajax({
                            type: "put",
                            url: href,
                            data: formdata,
                            dataType: "json",
                            success: function(res) {
                                if (res.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: res.message,
                                    }).then(function() {
                                        $('#modal-form').modal('hide');
                                        $('.save-form input').val('');
                                        $('.my-table').DataTable().ajax
                                            .reload();
                                    });
                                    return;
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: res.message,
                                    }).then(function() {

                                        $('.my-table').DataTable().ajax
                                            .reload();
                                    });
                                    return;
                                }
                            }
                        });
                        // no need to wait for timeout, re-enable the form ASAP
                        $(this).safeform('complete');
                        return false;
                    }
                })

            });


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
                ajax: '{{ route('users.index') }}',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fas fa-angle-right pgn-1" style="color: #017CC4"></span>',
                        sPrevious: '<span class="fas fa-angle-left pgn-2" style="color: #017CC4"></span>',
                        sFirst: '<span class="fas fa-angle-double-left pgn-3" style="color: #017CC4"></span>',
                        sLast: '<span class="fas fa-angle-double-right pgn-4" style="color: #017CC4"></span>',
                    }
                },
                columns: [{
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'fullname',
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'role',
                    },
                    {
                        data: 'default_wb',
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
