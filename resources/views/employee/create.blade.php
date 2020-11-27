@extends('adminlte::page')

@section('title', 'Add employee')

@section('content_header')
    <h3>Employees</h3>
@stop

@section('content')
    <form autocomplete="off" class="card rounded-0 shadow-none border" action="{{ route('employee.store') }}" enctype="multipart/form-data" method="POST" style="width: 38vw">
        @csrf

        <div class="card-body p-3">
            <h5 class="mb-4">Add employee</h5>

            <div class="form-group">
                <label for="photo" class="col-form-label">
                    <i class="{{ $errors->has('photo')? 'far fa-times-circle' : '' }}"></i>
                    Photo
                </label>
                @if ($errors->has('photo'))
                    <span class="invalid-feedback d-block mt-0 mb-1" role="alert">{{ $errors->first('photo') }}</span>
                @endif
                <label class="btn btn-flat btn-default btn-file" style="width: 38%; display: block;">
                    Browse <input  id="photo" name="photo" type="file"class="d-none">
                </label>
                <span class="text-gray">File format jpg,png up to 5MB, the minimum size of 300x300px</span>
            </div>

            <div class="form-group">
                <label for="full_name" class="col-form-label">
                    <i class="{{ $errors->has('full_name')? 'far fa-times-circle' : '' }}"></i>
                    Name
                </label>
                <input id="full_name" name="full_name" type="text" class="form-control {{ $errors->has('full_name')? 'is-invalid' : '' }}" maxlength="256">
                <span class="text-gray float-right pr-2" id="count_messege"></span>
                @if ($errors->has('full_name'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('full_name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="phone_number" class="col-form-label">
                    <i class="{{ $errors->has('phone_number')? 'far fa-times-circle' : '' }}"></i>
                    Phone
                </label>
                <input id="phone_number" name="phone_number" type="text" class="form-control {{ $errors->has('phone_number')? 'is-invalid' : '' }}">
                <span class="text-gray float-right pr-2">Required format +380 (xx) XXX XX XX</span>
                @if ($errors->has('phone_number'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('phone_number') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="email" class="col-form-label">
                    <i class="{{ $errors->has('email')? 'far fa-times-circle' : '' }}"></i>
                    Email
                </label>
                <input id="email" name="email" type="email" class="form-control {{ $errors->has('email')? 'is-invalid' : '' }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="position">Position</label>
                <select id="position" name="position_id" class="form-control">
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="salary" class="col-form-label">
                    <i class="{{ $errors->has('salary')? 'far fa-times-circle' : '' }}"></i>
                    Salary, $
                </label>
                <input id="salary" name="salary"
                       type="number" step="0.001"
                       class="form-control {{ $errors->has('salary')? 'is-invalid' : '' }}"
                @if ($errors->has('salary'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('salary') }}</span>
                @endif
            </div>

            <div class="form-group autocomplete">
                <label for="head" class="col-form-label">
                    <i class="{{ $errors->has('head')? 'far fa-times-circle' : '' }}"></i>
                    Head
                </label>
                <input id="head" name="head" type="text" class="form-control {{ $errors->has('head')? 'is-invalid' : '' }}" autocomplete="off">
                @if ($errors->has('head'))
                    <span class="invalid-feedback" role="alert">{{ $errors->first('head') }}</span>
                @endif
            </div>

            <div class="form-group date" data-provide="datepicker" data-date-format="dd.mm.yy">
                <label for="employment_date">Date of employment</label>
                <input id="employment_date" name="employment_date" autocomplete="off" class="form-control">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
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
    <script type="text/javascript">
        let text_max = 256;
        $('#count_messege').html('0 / ' + text_max);
        $('#full_name').keyup(function () {
            let text_len = $('#full_name').val().length;
            $('#count_messege').html(text_len + ' / ' + text_max);
        })
    </script>
    <script type="text/javascript">
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            let currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                let a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        let employees = [
            @foreach($employees->pluck('full_name')->all() as $emp)
                '{{ $emp }}',
            @endforeach
        ];

        /*initiate the autocomplete function on the "head" element, and pass along the employees array as possible autocomplete values:*/
        autocomplete(document.getElementById("head"), employees);
    </script>
@stop
