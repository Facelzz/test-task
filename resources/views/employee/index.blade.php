@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h3 class="mb-0 mt-auto">Employees</h3>
        <a class="btn btn-secondary btn-flat" href={{ route('employee.create') }}>Add employee</a>
    </div>
@stop

@section('content')
    <div class="card rounded-0 shadow-none border" style="border-color: #dee2e6;">
        <h5 class="pt-2 px-2 pb-3 m-0">Position list</h5>
        <table class="table data-table table-striped" width="100%" id="data-table">
            <thead style="/*font-size: small*/">
            <tr>
                <th width="5%" class="align-middle">Photo</th>
                <th class="align-middle">Name</th>
                <th class="align-middle">Position</th>
                <th>Day of employment</th>
                <th width="15%" class=align-middle">Phone number</th>
                <th class="align-middle">Email</th>
                <th class="align-middle">Salary</th>
                <th width="7%" class="align-middle">Action</th>
            </tr>
            </thead>
            <tbody style="/*font-size: small*/">
            </tbody>
        </table>
    </div>
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove employee</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="deleteContent">
                        Are you sure you want to remove employee <span class="dname"></span>?<span class="text-hide did"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-flat btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-secondary actionBtn" data-dismiss="modal">Remove</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .table thead th {
            border-bottom: none;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function ()
        {
            $('#data-table').DataTable({
                "dom": "<'d-flex justify-content-between px-2'lf><t><'d-flex justify-content-between px-2 pt-2 pb-3'ip>",
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.index') }}",
                columns: [
                    {data: 'photo', name: 'photo', className: 'text-center align-middle', orderable: false, searchable: false},
                    {data: 'full_name', name: 'full_name'},
                    {data: 'position_id', name: 'position_id'},
                    {data: 'employment_date', name:  'employment_date'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'email', name: 'email'},
                    {data: 'salary', name: 'salary'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });
        })
    </script>
    <script type="text/javascript">
        $(document).on('click', '.delete-modal', function() {
            let stuff = $(this).data('info').split(',');
            $('.actionBtn').addClass('delete');
            $('.did').text(stuff[0]);
            $('.dname').html(stuff[1]);
            $('#deleteModal').modal('show');
        });
        $(document).on('click', '.delete', function() {
            let row = $('.did').parents('tr');
            let table = $('.data-table').DataTable();
            let id = $('.did').text();
            $.ajax({
                type: 'DELETE',
                url: 'employee/'+id,
                data: {
                    'id': id
                },
                success: function(data) {
                    table.row(row).remove().draw();
                }
            });
        });
    </script>
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
@stop
