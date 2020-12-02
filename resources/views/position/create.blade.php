@extends('adminlte::page')

@section('title', 'Add position')

@section('content_header')
    <h3>Positions</h3>
@stop

@section('content')
    <form class="card rounded-0 shadow-none border" action="{{ route('position.store') }}" method="POST" style="width: 38vw">
        @csrf

        <div class="card-body p-3">
            <h5 class="mb-4">Add position</h5>

            <div class="form-group">
                <label class="col-form-label" for="name">
                    <i class="{{ $errors->has('name')? 'far fa-times-circle' : '' }}"></i>
                    Name
                </label>
                <input id="name" name="name" type="text" class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}" maxlength="256">
                <span class="text-gray float-right pr-2" id="count_messege"></span>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="pt-4">
                <button type="submit" class="btn btn-flat btn-primary float-right w-25 ml-4">Save</button>
                <a class="btn btn-default btn-flat float-right w-25" href="{{ route('position.index') }}">Cancel</a>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .was-validated .form-control:invalid, .form-control.is-invalid {
            background-image: none;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript">
        let text_max = 256;
        $('#count_messege').html('0 / ' + text_max);
        $('#name').keyup(function () {
            let text_len = $('#name').val().length;
            $('#count_messege').html(text_len + ' / ' + text_max);
        })
    </script>
@stop
