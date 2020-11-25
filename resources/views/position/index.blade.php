@extends('adminlte::page')

@section('title', 'Positions')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h3 class="mb-0 mt-auto">Positions</h3>
        <a class="btn btn-secondary btn-flat" href="{{ route('position.create') }}">Add position</a>
    </div>
@stop

@section('content')
    <div class="card rounded-0 shadow-none border" style="border-color: #dee2e6;">
        <h5 class="pt-2 px-2 pb-3 m-0">Position list</h5>
        <table class="table data-table table-striped" width="100%" id="data-table">
            <thead style="/*font-size: small*/">
            <tr>
                <th>Name</th>
                <th width="18%">Last update</th>
                <th width="7%">Action</th>
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
                    <h5 class="modal-title">Remove position</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="deleteContent">
                        Are you sure you want to remove position <span class="dname"></span>?<span class="text-hide did"></span>
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
                ajax: "{{ route('position.index') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'last_updated', name: 'last_updated'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
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
                url: 'position/'+id,
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
