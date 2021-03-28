@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Tags') }}</div>

                    <div class="card-body">
                        <form action="{{route('tags')}}" method="post" class="row">
                            @csrf
                            <div class="form-group col-md-6 ">
                                <label for="tag_text">Tag Name</label>
                                <input type="text" class="form-control" id="tag_name" name="tag_name"
                                       placeholder="Tag Name" required>
                            </div>

                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">Save New Tag</button>
                            </div>
                        </form>
                        <br>
                        <div class="row">
                            @foreach($tags as $tag)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <span class="buttons-span">
                                            <a class="edit-tag" data-tagid="{{$tag->id}}"
                                               data-tagname="{{$tag->tag}}"><span><i class="fas fa-edit"></i></span></a>
                                            <a class="delete-tag" data-tagid="{{$tag->id}}"
                                               data-tagname="{{$tag->tag}}"><span><i class="fas fa-trash-alt"></i></span></a>
                                        </span>
                                        <p>{{$tag->tag}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{(!is_null($showLinks) && $showLinks) ? $tags->links():''}}
                        <form action="{{route('search-tags')}}" method="get">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <input type="text" class="form-control" id="tag_search" name="tag_search"
                                           placeholder="Search Tag" required>
                                </div>
                                <div class="form-group col-md-6 ">
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
                    <h5 class="modal-title">Tag Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('tags')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="message-delete"></p>
                        <input type="hidden" name="tag_id" value="" id="tag_id">
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
                    <h5 class="modal-title">Edit Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('tags')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group col-md-6 ">
                            <label for="tag_text">Tag Name</label>
                            <input type="text" class="form-control" id="edit_tag_name" name="tag_name"
                                   placeholder="Tag Name" required>
                        </div>
                        <input type="hidden" name="_method"  value="put">
                        <input type="hidden" name="tag_id" value="" id="edit_tag_id">
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
                <strong class="mr-auto">Tag</strong>
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
            var $deleteTag = $('.delete-tag');
            var $deletewindow = $('.delete-window');
            var $tagId = $('#tag_id');
            var $deleteMessage = $('.message-delete');
            $deleteTag.on('click', function (element) {
                element.preventDefault();
                var $tag_id = $(this).data('tagid');
                var $tagName = $(this).data('tagname');
                $deleteMessage.text('Are you sure you want to delete '+ $tagName + ' ?');
                $tagId.val($tag_id);
                $deletewindow.modal('show')
            })
            $('#cancel1').on('click', function(e) {
                e.preventDefault();
                // Coding
                $('#delete-window').modal('toggle'); //or  $('#IDModal').modal('hide');
                return false;
            });
            var $editTag = $('.edit-tag');
            var $editwindow = $('.edit-window');
            var $edit_tag_name = $('#edit_tag_name');
            var $edit_tag_id = $('#edit_tag_id');
            $editTag.on('click', function (element){
                element.preventDefault();
                var tag_id = $(this).data('tagid');
                var tagName = $(this).data('tagname');
                $edit_tag_name.val(tagName);
                $edit_tag_id.val(tag_id);
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
