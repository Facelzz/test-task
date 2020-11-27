@extends('adminlte::page')

@section('title', 'Position edit')

@section('content_header')
    <h3>Employees</h3>
@stop

@section('content')
    <form autocomplete="off" class="card rounded-0 shadow-none border" action="{{ route('position.update', $position->id) }}" enctype="multipart/form-data" method="POST" style="width: 38vw; min-width: 400px;">
        @csrf
        @method('PUT')

        <div class="card-body p-3">
            <h5 class="mb-4">Position edit</h5>

            <div class="form-group">
                <label for="name" class="col-form-label">
                    <i class="{{ $errors->has('name')? 'far fa-times-circle' : '' }}"></i>
                    Name
                </label>
                <input id="name" name="name" type="text"
                       class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}"
                       value="{{ $position->name }}">
                <span class="text-gray float-right pr-2" id="count_messege"></span>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="row pt-2 mb-4">
                <div class="col pl-0">
                    <label>Created at:</label>
                    <span>{{ $position->created_at->format('d.m.y') }}</span>
                    <br>

                    <label>Updated at:</label>
                    <span>{{ $position->updated_at->format('d.m.y') }}</span>
                </div>
                <div class="col">
                    <label>Admin created ID:</label>
                    <span>{{ $position->admin_created_id }}</span>
                    <br>

                    <label>Admin updated ID:</label>
                    <span>{{ $position->admin_updated_id }}</span>
                </div>
            </div>

            <button type="submit" class="btn btn-flat btn-primary float-right w-25 ml-4">Save</button>
            <button class="btn btn-default btn-flat float-right w-25">Cancel</button>
        </div>
    </form>
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
        .was-validated .form-control:invalid, .form-control.is-invalid {
            background-image: none;
        }
    </style>
    <style>
        .autocomplete {
            position: relative;
            display: block;
        }
        .autocomplete input {
            padding: 10px;
        }
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
        }
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: none;
        }
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    {{--Symbol counter for text input--}}
    <script type="text/javascript">
        let text_max = 256;
        $('#count_messege').html('0 / ' + text_max);
        $('#name').keyup(function () {
            let text_len = $('#name').val().length;
            $('#count_messege').html(text_len + ' / ' + text_max);
        })
    </script>
@stop
