@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {!! !is_null($product) ? 'Update Product <span class="product-header-title">'.$product->title :' New Product' !!}
                </div>
                <div class="card-body">
                    <form action="{{(! is_null($product)) ?route('update-product'):route('new-product')}}" method="post"
                          class="row" enctype="multipart/form-data">


                        @csrf
                        @if(! is_null($product)  )
                            <input type="hidden" name="_method" value="PUT"/>
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                        @endif

                        <div class="form-group col-md-12 ">
                            <label for="product_title">Product Title</label>
                            <input type="text" class="form-control" id="product_title" name="product_title"
                                   placeholder="Product title" required
                                   value="{{(!is_null($product)) ? $product->title : '' }}">
                        </div>


                        <div class="form-group col-md-12 ">
                            <label for="product_description">Product Description</label>
                            <textarea placeholder="Product Description" required class="form-control"
                                      name="product_description" id="product_description" cols="30"
                                      rows="10">
                                {{(! is_null($product))? $product->description :''}}
                            </textarea>
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="product_category">Product Category</label>
                            <select class="form-control" name="product_category" id="product_category" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{$category->id}}" {{(! is_null($product) && $product->category->id===$category->id ) ? 'selected' :''}}>{{$category->name}}
                                    </option>

                                @endforeach


                            </select>
                        </div>

                        <div class="form-group col-md-12 ">
                            <label for="product_unit">Product Unit</label>
                            <select class="form-control" name="product_unit" id="product_unit" required>
                                <option>Select Unit</option>


                                @foreach($units as $unit)

                                    <option value="{{$unit->id}}"
                                        {{(! is_null($product) && $product->hasUnit->id===$unit->id ) ? 'selected' :''}}>{{$unit->formatted()}}
                                    </option>

                                @endforeach


                            </select>
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" step="any"
                                   placeholder="Product price" required
                                   value="{{(!is_null($product)) ? $product->price : '' }}">
                        </div>

                        <div class="form-group col-md-6 ">
                            <label for="product_discount">Product Discount</label>
                            <input type="number" class="form-control" id="product_discount" name="product_discount"
                                   step="any"
                                   placeholder="Product Discount" required
                                   value="{{(!is_null($product)) ? $product->discount : '' }}">
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="product_total">Product Total</label>
                            <input type="number" class="form-control" id="product_total" name="product_total" step="any"
                                   placeholder="Product total" required
                                   value="{{(!is_null($product)) ? $product->total : '' }}">
                        </div>


                        {{--                        Options--}}

                        <div class="form-group col-md-12 ">
                            <table id="options-table" class="table table-striped">
                                @if(! is_null($product))
                                    @if(!is_null($product->jsonOptions()))
                                        @foreach($product->jsonOptions() as $optionName =>$options)
                                            @foreach($options as $option)
                                                <tr>
                                                    <td> {{$optionName}}</td>
                                                    <td>{{$option}}</td>
                                                    <td>
                                                        <a href="" class="remove-option"><i
                                                                class="fas fa-minus-circle"></i></a>
                                                        <input type="hidden" name="{{$optionName}}[]"
                                                               value="{{$option}}">
                                                    </td>

                                                </tr>

                                            @endforeach
                                            <td><input type="hidden" name="options[]" value="{{$optionName}}"></td>;


                                        @endforeach
                                    @endif

                                @endif


                            </table>
                            <a class="btn btn-outline-dark add-option-btn" href="#">
                                Add Options
                            </a>

                        </div>

                        {{--                        /options--}}

                        {{--                        Image--}}
                        <div class="form-group col-md-12 ">
                            <div class="row">
                                @for($i=0; $i<6; $i++)
                                    <div class="col-md-4 col-sm-12 mb-4">

                                        <div class="card image-card-upload">
                                            <a href="#" class="remove-image-upload">
                                                <i class="fas fa-minus-circle"></i></a>
                                            <a class="activate-image-upload" href="#" data-fileid="image-{{$i}}">
                                                <div class="card-body" style="text-align: center">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            </a>
                                            <input name="product_images[]" type="file"
                                                   class="form-control-file image-file-upload"
                                                   id="image-{{$i}}">
                                        </div>

                                    </div>
                                @endfor
                            </div>
                        </div>
{{--                        <div class="form-group col-md-12 ">--}}
{{--                            <div class="row">--}}
{{--                                @for($i=0;$i<6;$i++)--}}
{{--                                    <div class="col-md-4 col-sm-12 mb-4">--}}
{{--                                        <div class="card image-card-upload">--}}
{{--                                            @if(! is_null($product->images) && count($product->images)>0)--}}
{{--                                                @if(isset($product->images[$i])&& !is_null($product->images[$i]) &&  !empty($product->images[$i]))--}}
{{--                                                    <a href="#" class="remove-image-upload"--}}
{{--                                                       data-imgid="{{$product->images[$i]->id}}"--}}
{{--                                                       data-removeimg="removeimg-{{$i}}" data-fileid="image-{{$i}}">--}}
{{--                                                        <i--}}
{{--                                                            class="fas fa-minus-circle" style="display: none"></i></a>--}}
{{--                                                @else--}}
{{--                                                    <a href="#" class="activate-image-upload"--}}
{{--                                                       data-fileid="image-{{$i}}" id="removeimg-{{$i}}"><i--}}
{{--                                                            class="fas fa-minus-circle" style="display: none"></i></a>--}}

{{--                                                @endif--}}
{{--                                            @endif--}}


{{--                                            @if(! is_null($product->images) && count($product->images)>0)--}}
{{--                                                @if(isset($product->images[$i])&& !is_null($product->images[$i]) &&  !empty($product->images[$i]))--}}

{{--                                                    <img id="{{'iimage-'. $i}}"--}}
{{--                                                         src="{{asset($product->images[$i]->url)}}"--}}
{{--                                                         class="card-img-top" alt="">--}}
{{--                                                @endif--}}
{{--                                            @endif--}}

{{--                                            <div class="card-body" style="text-align: center">--}}
{{--                                                @if(! is_null($product->images) && count($product->images)>0)--}}
{{--                                                    @if(isset($product->images[$i])&& !is_null($product->images[$i]) &&  !empty($product->images[$i]))--}}
{{--                                                        <i class="fas fa-image" style="display: none"></i>--}}
{{--                                                    @else--}}
{{--                                                        <i class="fas fa-image"></i>--}}

{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <i class="fas fa-image"></i>--}}

{{--                                                @endif--}}

{{--                                            </div>--}}
{{--                                            @if(! is_null($product->images) && count($product->images)>0)--}}
{{--                                                @if(isset($product->images[$i])&& !is_null($product->images[$i]) &&  !empty($product->images[$i]))--}}
{{--                                                    <input name="product_images[]" type="file"--}}
{{--                                                           class="form-control-file image-file-upload"--}}
{{--                                                           id="image-{{$i}}" value={{asset($product->images[$i])}}>--}}
{{--                                                @else--}}
{{--                                                    <input name="product_images[]" type="file"--}}
{{--                                                           class="form-control-file image-file-upload"--}}
{{--                                                           id="image-{{$i}}" value={{asset($product->images[$i])}}>--}}
{{--                                                @endif--}}
{{--                                            @else--}}
{{--                                                <input name="product_images[]" type="file"--}}
{{--                                                       class="form-control-file image-file-upload"--}}
{{--                                                       id="image-{{$i}}" value={{asset($product->images[$i])}}>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endfor--}}

{{--                            </div>--}}
{{--                        </div>--}}

                        {{--                        /Images--}}

                        <div class="form-group col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-block">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal options-window" tabindex="-1" role="dialog" id="options-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body row">

                    <div class="form-group col-md-6 ">
                        <label for="option_name">Option Name</label>
                        <input type="text" class="form-control" id="option_name" name="option_name"
                               placeholder="option Name" required>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="option_value">Option Value</label>
                        <input type="text" class="form-control" id="option_value" name="option_value"
                               placeholder="Option value" required>
                    </div>

                    <input type="hidden" name="unit_id" id="edit_unit_id">
                    <input type="hidden" name="_method" value="put"/>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary add-option-button">ADD OPTION</button>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        var optionsNamesList = [];
    </script>

    @if(!is_null($product))
        @if(!is_null($product->jsonOptions()))
            @foreach($product->jsonOptions() as $optionName =>$options)
                <script>optionsNamesList.push('{{$optionName}}'); </script>


            @endforeach

        @endif
    @endif
    <script>
        {{--//var imageDelete='{{route('delete-image')}}'--}}
    </script>


    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $(document).ready(function () {
            console.log(optionsNamesList);
            var $optionWindow = $('#options-window');
            var addOptionBtn = $('.add-option-btn');
            var $optionsTable = $('#options-table');
            var $activateImageUpload = $('.activate-image-upload');
            addOptionBtn.on('click', function (e) {
                e.preventDefault();
                $optionWindow.modal('show');
            });
            $(document).on('click', '.remove-option', function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
            $(document).on('click', '.add-option-button', function (e) {
                e.preventDefault();
                var $optionName = $('#option_name');
                if ($optionName.val() === '') {
                    alert('Option Name is required');
                    return false;
                }
                var $optionValue = $('#option_value');
                if ($optionValue.val() === '') {
                    alert('Option Value is required');
                    return false
                }
                if (!optionsNamesList.includes($optionName.val())) {
                    optionsNamesList.push($optionName.val());
                }
                var optionNameRow = ' <td> <input type="hidden" name="options[]" value="' + $optionName.val() + ' "></td>';
                var optionRow = `
            <tr>
                <td>
                    ` + $optionName.val() + `
                </td>
                <td>
                    ` + $optionValue.val() + `
                </td>
                <td>
                        <a href="" class="remove-option"><i class="fas fa-minus-circle"></i></a>
                        <input type="hidden" name="` + $optionName.val() + `[]" value="` + $optionValue.val() + `">
                </td>
            </tr>
            `;
                $optionsTable.append(
                    optionRow
                );
                $optionsTable.append(
                    optionNameRow
                );
                $optionValue.val('')
            });
            function readURL(input, imageID) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#' + imageID).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function resetFileUpload(fileUploadID, imageID, $eI, $eD) {
                $('#' + imageID).attr('src', '');
                $eI.fadeIn();
                $eD.fadeOut();
                $('#' + fileUploadID).val('');
            }
            // $activateImageUpload.on('click', function (e) {
            //     e.preventDefault();
            //     var $fileUploadID = $(this).data('fileid');
            //     var me = $(this);
            //     $('#' + $fileUploadID).trigger('click');
            //     var $imagetag = '<img id="i' + $fileUploadID + '" src="" class="card-img-top" alt="">';
            //     $('#' + $fileUploadID).on('change', function () {
            //         readURL(this, 'i' + $fileUploadID);
            //         $imagetag = '';
            //         me.find('i').fadeOut();
            //         var $removeThisImage = me.parent().find('.remove-image-upload');
            //         $removeThisImage.fadeIn();
            //         $removeThisImage.on('click', function (e) {
            //             e.preventDefault();
            //             resetFileUpload('#' + $fileUploadID, 'i' + $fileUploadID, me.find('i'), $removeThisImage);
            //         })
            //     });
            //     $(this).append($imagetag);
            // });
            // $('.remove-image-upload').on('click', function (e) {
            //     e.preventDefault();
            //     var me = $(this);
            //     var imageID= me.data('imageid');
            //     var removeID = $(this).data('removeimg');
            //     var fileUploadID = $(this).data('fileid');
            //     var $removeThisImage = me.parent().find('.remove-image-upload');
            //     resetFileUpload($fileUploadID, 'i' + fileUploadID, $('#' + removeID).find('i'), $removeThisImage);
            //     $.ajax({
            //         url:imageDelete,
            //         data:{
            //             image_id: imageID,
            //         },
            //         dataType:'json',
            //         method:post
            //     });
            //})
            $activateImageUpload.on('click', function (e) {
                e.preventDefault();
                var fileUploadID = $(this).data('fileid');
                // console.log('#'+$fileUploadID);
                var me = $(this);
                $('#'+fileUploadID).trigger('click');
                var $imagetag = '<img id="i' + fileUploadID + '" src="" class="card-img-top" alt="">';
                $(this).append($imagetag);
                $('#'+fileUploadID).on('change', function (){
                    readURL(this, 'i'+fileUploadID);
                    me.find('i').fadeOut();
                            me.find('i').fadeOut();
                            var $removeThisImage = me.parent().find('.remove-image-upload');
                            $removeThisImage.fadeIn();
                            $removeThisImage.on('click', function (e) {
                                e.preventDefault();
                                resetFileUpload( fileUploadID, 'i' + fileUploadID, me.find('i'), $removeThisImage);
                            })
                })
            })
        })
    </script>


@endsection
