@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('additional_css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/ion-rangeslider/ion-rangeslider.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/devices.min.css')}}">
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item">Brands</li>
    <li class="breadcrumb-item">{{$brand_name}}</li>
    <li class="breadcrumb-item active">Update Product</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Update </span>Product <span class="fw-300">|</span><span class='fw-400 color-primary-500'> {{$brand_name}}</span>
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col">
    <form method="post" action="/edit_brand_product/{{$product->connection_id}}" enctype="multipart/form-data">
        @csrf
        <!-- Status -->
        <div id="panel-product" class="panel" style="">
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-active" name="product_status" value="1" <?php if($product->status == 1){echo 'checked';}?>>
                                    <label class="custom-control-label" for="product-active"><span class="badge badge-success w-100">ACTIVE</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-inactive" name="product_status" value="0" <?php if($product->status == 0){echo 'checked';}?>>
                                    <label class="custom-control-label" for="product-inactive"><span class="badge badge-danger w-100">INACTIVE</span></label>
                                </div>
                                {{-- <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-draft" name="product_status">
                                    <label class="custom-control-label" for="product-draft"><span class="badge badge-secondary w-100">DRAFT</span></label>
                                </div> --}}
                            </div>
                        </div><!-- PRODUCT INFO -->
                </div>
            </div>
        </div>
        <div id="panel-product" class="panel" style="">
            <!-- <div class="panel-hdr">
                <h2>
                    Product Details</span>
                </h2>
            </div> -->
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    {{-- <form> --}}
                        <!-- Brand Name -->
                        {{-- <div class="form-group">
                            <label class="form-label" for="brand">Brand Name</label>
                            <input type="text" id="brand" class="form-control inputAutoComplete" autocomplete="off">
                        </div> --}}
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label" for="name">Product Name</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{$product->name}}" required>
                        </div>
                        <!-- Product Type -->
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select id="product-category" class="custom-select form-control" name="category">
                                <option value="0" <?php if($product->category == 0){echo 'selected';}?>>Flower</option>
                                <option value="1" <?php if($product->category == 1){echo 'selected';}?>>Edible</option>
                                <option value="2" <?php if($product->category == 2){echo 'selected';}?>>Concentrate</option>
                                <option value="3" <?php if($product->category == 3){echo 'selected';}?>>Deal</option>
                            </select>
                        </div>
                        <!-- Sative Indica Hybrid -->
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="checkbox" class="custom-control-input" id="indica" name="type_indica" <?php if(in_array(0, $product->types)){echo 'checked';}?>>
                                    <label class="custom-control-label" for="indica"><span class="badge border border-danger text-danger w-100">INDICA</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="checkbox" class="custom-control-input" id="sativa" name="type_sativa" <?php if(in_array(1, $product->types)){echo 'checked';}?>>
                                    <label class="custom-control-label" for="sativa"><span class="badge border border-warning text-warning w-100">SATIVA</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="checkbox" class="custom-control-input" id="hybrid" name="type_hybrid" <?php if(in_array(2, $product->types)){echo 'checked';}?>>
                                    <label class="custom-control-label" for="hybrid"><span class="badge border border-success text-success w-100">HYBRID</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="checkbox" class="custom-control-input" id="cbd" name="type_cbd" <?php if(in_array(3, $product->types)){echo 'checked';}?>>
                                    <label class="custom-control-label" for="cbd"><span class="badge border border-secondary text-secondary w-100">CBD</span></label>
                                </div>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="form-group">
                            <label class="form-label">Photo</label>
                            <div clas="form-control">
                                @if($product->image != '')
                                    <img src="{{$product->image}}" width="295" height="295" class="img-border preview_product" />
                                @else
                                    <img src="https://via.placeholder.com/295x295?text=PRODUCT" width="295" height="295" class="img-border preview_product" />
                                @endif
                            </div>
                            {{-- <div id="upload-photo"></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div> --}}
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="product" name="product">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                        </div>
                        <!-- Popular -->
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="popular-no" name="popular" value="0" <?php if($product->popular == 0){echo 'checked';}?>>
                                    <label class="custom-control-label" for="popular-no"><span class="badge badge-danger w-100">NO</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="popular-yes" name="popular" value="1" <?php if($product->popular == 1){echo 'checked';}?>>
                                    <label class="custom-control-label" for="popular-yes"><span class="badge badge-success w-100">YES</span></label>
                                </div>
                            </div>
                        </div><!-- Popular -->
                        <!-- Description -->
                        <div class="form-group">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" id="description" rows="5" name="description">{{$product->description}}</textarea>
                        </div>                          
                    </div>
                {{-- </form> --}}
            </div>
        </div>
        <!-- CHARACTERISTICS -->
        <div id="panel-characteristics" class="panel" style="">
            <!-- <div class="panel-hdr">
                <h2>
                    Product Characteristics</span>
                </h2>
            </div> -->
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- <div class="panel-tag">
                        Use your own prettify function to transform numbers whatever you like
                    </div> -->
                    <div class="form-group">
                        <label class="form-label" for="">Happy</label>
                        <input id="demo_happy" type="text" value="" name="attr_happy" class="characteristic d-none form-control" tabindex="-1" readonly="false">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Relaxed</label>
                        <input id="demo_relaxed" type="text" value="" name="attr_relaxed" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Euphoric</label>
                        <input id="demo_euphoric" type="text" value="" name="attr_euphoric" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Uplifted</label>
                        <input id="demo_uplifted" type="text" value="" name="attr_uplifted" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Creativity</label>
                        <input id="demo_creativity" type="text" value="" name="attr_creativity" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Stress Relief</label>
                        <input id="demo_stress_relief" type="text" value="" name="attr_stress" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Depression Relief</label>
                        <input id="demo_depression_relief" type="text" value="" name="attr_depression" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Pain Relief</label>
                        <input id="demo_pain_relief" type="text" value="" name="attr_pain" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Loss of Appetite</label>
                        <input id="demo_loss_appetite" type="text" value="" name="attr_appetite" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="">Insomnia</label>
                        <input id="demo_insomnia" type="text" value="" name="attr_insomnia" class="characteristic d-none form-control" tabindex="-1" readonly="">
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- PRICING -->
        <div id="panel-pricing" class="panel" style="">
            <!-- <div class="panel-hdr">
                <h2>
                    Product Pricing</span>
                </h2>
            </div> -->
            <div class="panel-container show">
                {{-- <form> --}}
                    <div class="panel-content">
                    
                        <!-- Pricing -->
                        <div class="form-group price_quantity">
                            <label class="form-label" for="basic-url">Price per product</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" name="price_product" value="{{$product->prices[0]}}" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                        <!-- Pricing -->
                        <div class="form-group price_weight">
                            <label class="form-label" for="basic-url">Price per 1 gram</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" name="price_half" value="{{$product->prices[1]}}" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                        <!-- Pricing -->
                        <div class="form-group price_weight">
                            <label class="form-label" for="basic-url">Price per 1/4 ounce</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" name="price_one" value="{{$product->prices[2]}}" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                        <!-- Pricing -->
                        <div class="form-group price_weight">
                            <label class="form-label" for="basic-url">Price per 1/8 ounce</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" name="price_ounce" value="{{$product->prices[3]}}" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                                                                    
                    </div>
                    {{-- </form> --}}
                    <!-- <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="invalidCheck" required="">
                            <label class="custom-control-label" for="invalidCheck">Agree to terms and conditions <span class="text-danger">*</span></label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                        <a href="products.html" class="ml-auto"><button class="btn btn-primary ml-auto" type="submit">Add Product to Menu</button></a>
                    </div> -->
                
            </div>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Update Product</button>
    </form>
    </div>
    <div class="col" style="max-width: 440px; min-width: 440px; width: 440px;">
        <div class="marvel-device iphone-x">
            <div class="notch">
                <div class="camera"></div>
                <div class="speaker"></div>
            </div>
            <div class="top-bar"></div>
            <div class="sleep"></div>
            <div class="bottom-bar"></div>
            <div class="volume"></div>
            <div class="overflow">
                <div class="shadow shadow--tr"></div>
                <div class="shadow shadow--tl"></div>
                <div class="shadow shadow--br"></div>
                <div class="shadow shadow--bl"></div>
            </div>
            <div class="inner-shadow"></div>
            <div class="screen">
                <!-- <object id="svg-object" data="img/app.svg" type="image/svg+xml"></object> -->
                <!-- <img src="img/app.svg" width="100%"> -->
                <img src="{{asset('img/app-top-menu.svg')}}" width="100%" style="position: absolute; top: 0;">
                <div class="screen-scroll">
                    <img src="{{asset('img/app.svg')}}" width="100%">
                </div>
                <img src="{{asset('img/app-bottom-menu.svg')}}" width="100%" style="position: absolute; bottom: 0;">
                
                
            </div>
        </div>
    </div>
</div>
<!-- END ACTUAL PAGE CONTENT -->
@endsection

@section('additional_scripts')
<script src="{{asset('js/formplugins/ion-rangeslider/ion-rangeslider.js')}}"></script>
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script type="text/javascript">
    
    var product = <?php echo $product;?>;
    var attributes = product['attributes'];

    $image_crop_photo = $('#upload-photo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#upload-photo').hide();
    
    $('#photo').on('change', function () { 
        $('#upload-photo').show();
        var readerPhoto = new FileReader();
        readerPhoto.onload = function (e) {
            $image_crop_photo.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });         
        }
        readerPhoto.readAsDataURL(this.files[0]);
    });

    var ionskin = "flat";
    
    function my_prettify(n)
    {
        // var num = Math.log2(n);
        // return n + " → " + (+num.toFixed(3));
        return n+"%";
    }

    for(var i = 0; i < $(".characteristic").length; i++){
        $($(".characteristic")[i]).ionRangeSlider(
        {
            skin: ionskin,
            grid: true,
            min: 0,
            max: 100,
            from: Object.values(attributes)[i],
            prettify: my_prettify
        });
    }

</script>
<script>
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
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

    /*An array containing all the country names in the world:*/
    var brands = ["3CHI", "420SMART", "7Acres", "Incredibles", "420 Gold", "420 Awesome"];

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/

    // TO DO PULL LIST OF BRANDS FROM DATABASE AND FEED TO AUTOCOMPLETE FUNCTION
    autocomplete(document.getElementById("brand"), brands);
</script>
@endsection