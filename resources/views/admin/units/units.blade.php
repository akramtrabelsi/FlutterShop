@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Units') }}</div>

                    <div class="card-body">
                        <form action="{{route('units')}}" method="post" class="row">
                            @csrf
                            <div class="form-group col-md-6 ">
                                <label for="unit_text">Unit Name</label>
                                <input type="text" class="form-control" id="unit_name" name="unit_name"
                                       placeholder="Unit Name" required>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="unit_code">Unit Code</label>
                                <input type="text" class="form-control" id="unit_code" name="unit_code"
                                       placeholder="Unit Code" required>
                            </div>
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">Save New Unit</button>
                            </div>
                        </form>
                        <br>
                        <div class="row">
                            @foreach($units as $unit)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <span class="buttons-span">
                                            <a class="edit-unit" data-unitid="{{$unit->id}}"
                                                                 data-unitname="{{$unit->unit_name}}"
                                                                 data-unitcode="{{$unit->unit_code}}" ><span><i class="fas fa-edit"></i></span></a>
                                            <a class="delete-unit" data-unitid="{{$unit->id}}"
                                                                   data-unitname="{{$unit->unit_name}}"
                                                                   data-unitcode="{{$unit->unit_code}}"><span><i class="fas fa-trash-alt"></i></span></a>
                                        </span>
                                        <p>{{$unit->unit_name}}</p>
                                        <p>{{$unit->unit_code}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{$units->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal delete-window" tabindex="-1" id="delete-window">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unit Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('units')}}" method="post">
                    @csrf
                    <div class="modal-body">
                    <p class="message-delete"></p>
                        <input type="hidden" name="unit_id" value="" id="unit_id">
                        <input type="hidden" name="_method"  value="delete">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel1" >CANCEL</button>
                    <button type="submit" class="btn btn-primary">DELETE</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('units')}}" method="post">
                    @csrf
                <div class="modal-body">
                        <div class="form-group col-md-6 ">
                            <label for="unit_text">Unit Name</label>
                            <input type="text" class="form-control" id="edit_unit_name" name="unit_name"
                                   placeholder="Unit Name" required>
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="unit_code">Unit Code</label>
                            <input type="text" class="form-control" id="edit_unit_code" name="unit_code"
                                   placeholder="Unit Code" required>
                        </div>
                    <input type="hidden" name="_method"  value="put">
                    <input type="hidden" name="unit_id" value="" id="edit_unit_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel2">CANCEL</button>
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @if(\Illuminate\Support\Facades\Session::has('message'))
        <div class="toast" style="position: absolute; z-index: 9999; top: 5%;right: 5%" >
            <div class="toast-header">
                <strong class="mr-auto">Unit</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                    {{\Illuminate\Support\Facades\Session::get('message')}}
            </div>
        </div>
    @endif


@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var $deleteUnit = $('.delete-unit');
            var $deletewindow = $('.delete-window');
            var $unitId = $('#unit_id');
            var $deleteMessage = $('.message-delete');
            $deleteUnit.on('click', function (element) {
                element.preventDefault();
                var $unit_id = $(this).data('unitid');
                var $unitName = $(this).data('unitname');
                var $unitCode = $(this).data('unitcode');
                $deleteMessage.text('Are you sure you want to delete '+ $unitName + ' with code ' + $unitCode + ' ?');
                $unitId.val($unit_id);
                $deletewindow.modal('show')
            })
            $('#cancel1').on('click', function(e) {
                e.preventDefault();
                // Coding
                $('#delete-window').modal('toggle'); //or  $('#IDModal').modal('hide');
                return false;
            });
            var $editUnit = $('.edit-unit');
            var $editwindow = $('.edit-window');
            var $edit_unit_code = $('#edit_unit_code');
            var $edit_unit_name = $('#edit_unit_name');
            var $edit_unit_id = $('#edit_unit_id');
            $editUnit.on('click', function (element){
                element.preventDefault();
                var unit_id = $(this).data('unitid');
                var unitName = $(this).data('unitname');
                var unitCode = $(this).data('unitcode');
                $edit_unit_code.val(unitCode);
                $edit_unit_name.val(unitName);
                $edit_unit_id.val(unit_id);
                $editwindow.modal('show');
            })
            $('#cancel2').on('click', function(e) {
                e.preventDefault();
                // Coding
                $('#edit-window').modal('toggle'); //or  $('#IDModal').modal('hide');
                return false;
            });
        })
    </script>
    @if(\Illuminate\Support\Facades\Session::has('message'))
            <script>
                $(document).ready(function (){
                    var $toast= $('.toast').toast({
                        autohide : false,
                    });
                    $toast.toast('show');
                });
            </script>

    @endif
@endsection

