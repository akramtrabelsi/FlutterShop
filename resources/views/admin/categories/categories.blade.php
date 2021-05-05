@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Categories') }}</div>

                    <div class="card-body">
                        <form action="{{route('categories')}}" method="post" class="row">
                            @csrf
                            <div class="form-group col-md-6 ">
                                <label for="tag_text">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                       placeholder="Category Name" required>
                            </div>

                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">Save New Category</button>
                            </div>
                        </form>
                        <br>
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <span class="buttons-span">
                                            <a class="edit-category" data-categoryid="{{$category->id}}"
                                               data-categoryname="{{$category->name}}"><span><i class="fas fa-edit"></i></span></a>
                                            <a class="delete-category" data-categoryid="{{$category->id}}"
                                               data-categoryname="{{$category->name}}"><span><i class="fas fa-trash-alt"></i></span></a>
                                        </span>
                                        <p>{{$category->name}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{(!is_null($showLinks) && $showLinks) ? $categories->links():''}}
                        <form action="{{route('search-categories')}}" method="get">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <br>
                                    <input type="text" class="form-control" id="category_search" name="category_search"
                                           placeholder="Search Category" required>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <br>
                                    <button type="submit" class="btn btn-primary">SEARCH</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal delete-window" tabindex="-1" id="delete-window">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('categories')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="message-delete"></p>
                        <input type="hidden" name="category_id" value="" id="category_id">
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
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('categories')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group col-md-6 ">
                            <label for="tag_text">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="category_name"
                                   placeholder="Category Name" required>
                        </div>
                        <input type="hidden" name="_method"  value="put">
                        <input type="hidden" name="category_id" value="" id="edit_category_id">
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
                <strong class="mr-auto">Category</strong>
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
            var $deleteCategory = $('.delete-category');
            var $deletewindow = $('.delete-window');
            var $categoryId = $('#category_id');
            var $deleteMessage = $('.message-delete');
            $deleteCategory.on('click', function (element) {
                element.preventDefault();
                var $category_id = $(this).data('categoryid');
                var $categoryName = $(this).data('categoryname');
                $deleteMessage.text('Are you sure you want to delete '+ $categoryName + ' ?');
                $categoryId.val($category_id);
                $deletewindow.modal('show')
            })
            $('#cancel1').on('click', function(e) {
                e.preventDefault();
                // Coding
                $('#delete-window').modal('toggle'); //or  $('#IDModal').modal('hide');
                return false;
            });
            var $editCategory = $('.edit-category');
            var $editwindow = $('.edit-window');
            var $edit_category_name = $('#edit_category_name');
            var $edit_category_id = $('#edit_category_id');
            $editCategory.on('click', function (element){
                element.preventDefault();
                var category_id = $(this).data('categoryid');
                var categoryName = $(this).data('categoryname');
                $edit_category_name.val(categoryName);
                $edit_category_id.val(category_id);
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

