@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{  route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{  route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">{{ $product->title }}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            @include('front.account.common.message')
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">

                        @if ($product->product_images)
                            @foreach ($product->product_images as $key => $prdocutImage)
                            <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                <img class="w-100 h-100" src="{{ asset('uploads/product/large/'.$prdocutImage->image)}}" alt="Image">
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{ $product->title }}</h1>
                    <div class="d-flex mb-3">
                        {{-- <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div> --}}

                        <div class="star-rating product mt-2" title="">
                            <div class="back-stars">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                
                                <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>  
                        <small class="pt-2 ps-1">({{ ($product->product_ratings_count > 0) ? 
                        $product->product_ratings_count.' Reviews' : 
                        $product->product_ratings_count.' Review'}})</small>
                    </div>

                    @if ($product->compare_price  > 0) 
                    <h2 class="price text-secondary"><del>${{ $product->compare_price }}</del></h2>
                    @endif


                    <h2 class="price ">${{ $product->price }}</h2>

                    {!! $product->short_description !!}

                    {{-- <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a> --}}

                    @if($product->track_qty == 'Yes')
                            @if ($product->qty > 0)
                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                    <i class="fa fa-shopping-cart"></i> &nbsp;Add To Cart
                                </a> 
                            @else
                                <a class="btn btn-dark" href="javascript:void(0);">
                                    Out Of Stock
                                </a> 
                            @endif                           
                        @else
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i> &nbsp;Add To Cart
                            </a> 
                        @endif
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">About Artist</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            {!! $product->description !!}
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                          <h1>Shipping</h1>
                          <p>We understand how important it is for our customers to receive their orders quickly and safely. That's why we strive to ensure that your products are carefully packaged and shipped as quickly as possible. Once your order is confirmed, we will process and dispatch it within [insert time frame, e.g., 2-3 business days]. Depending on your location, delivery may take [insert estimated delivery time, e.g., 5-7 business days]. You will receive a tracking number as soon as your order is shipped so you can easily track your package.
                            <br><br>
                            Please note that shipping fees are calculated based on your location and the weight of your order. We offer multiple shipping options to give you flexibility and convenience.
                           </p>
                           <br>
                           <h1>Returns</h1>
                           <p>At Artisan Have, your satisfaction is our top priority. If for any reason you are not completely satisfied with your purchase, we offer a hassle-free return policy. You may return any product within 3 days of receiving it, provided it is unused, in its original packaging, and in resalable condition.
                            <br><br>
                            To initiate a return, simply contact our customer service team, and we will guide you through the process. Please note that the cost of return shipping will be the responsibility of the customer, unless the item is defective or damaged upon arrival.
                            <br><br>
                            We aim to ensure that every customer is happy with their purchase. If you have any concerns or questions, don't hesitate to reach out to us—we're here to help!</p>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="col-md-8">
                                <div class="row">
                                <form action="" method="post" name="productRatingForm" id="productRatingForm">
                                    <h3 class="h4 pb-3">Write a Review</h3>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                        <p></p>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                        <p></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="rating">Rating</label>
                                        <br>
                                        <div class="rating" style="width: 10rem">
                                            <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                        </div>
                                        <p class="product-rating-error text-danger"></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">How was your overall experience?</label>
                                        <textarea name="comment"  id="comment" class="form-control" cols="30" rows="10" placeholder="How was your overall experience?"></textarea>
                                        <p></p>
                                    </div>
                                    <div>
                                        <button class="btn btn-dark">Submit</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="overall-rating mb-3">
                                    <div class="d-flex">
                                        <h1 class="h3 pe-3">{{ $avgRating }}</h1>
                                        <div class="star-rating mt-2" title="">
                                            <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                
                                                <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="pt-2 ps-2">({{ ($product->product_ratings_count > 0) ? 
                                        $product->product_ratings_count.' Reviews' : 
                                        $product->product_ratings_count.' Review'}})</div>
                                    </div>
                                    
                                </div>

                                @if ($product->product_ratings->isNotEmpty())
                                   @foreach ($product->product_ratings as $rating)
                                   @php
                                       $ratingPer = ($rating->rating*100)/5; 
                                   @endphp

                                   <div class="rating-group mb-4">
                                    <span> <strong>{{ $rating->username }} </strong></span>
                                     <div class="star-rating mt-2" title="">
                                         <div class="back-stars">
                                             <i class="fa fa-star" aria-hidden="true"></i>
                                             <i class="fa fa-star" aria-hidden="true"></i>
                                             <i class="fa fa-star" aria-hidden="true"></i>
                                             <i class="fa fa-star" aria-hidden="true"></i>
                                             <i class="fa fa-star" aria-hidden="true"></i>
                                             
                                             <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                                 <i class="fa fa-star" aria-hidden="true"></i>
                                             </div>
                                         </div>
                                     </div>   
                                     <div class="my-3">
                                         <p>{{ $rating->comment }} </p>
                                     </div>
                                 </div>
                                   @endforeach 
                                @endif
                              

                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>           
    </div>
</section>

@if(!empty($relatedProducts))
<section class="pt-5 section-8">
    <div class="container">
        <div class="section-title">
            <h2>Related Products</h2>
        </div> 
        <div class="col-md-12">
            <div id="related-products" class="carousel">

                @foreach ($relatedProducts as $relProduct)
                @php
                $productImage =  $relProduct->product_images->first(); 
                @endphp
                <div class="card product-card">
                    <div class="product-image position-relative">

                        <a href="{{ route('front.product',$relProduct->slug)}}" class="product-img">
                            {{-- <img class="card-img-top" src="images/product-1.jpg" alt=""> --}}
                            @if (!empty($productImage->image))
                            <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image) }}"/>
                            @else
                            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}"/>
                            @endif
                        </a>

                        <a onclick="addToWishList({{ $product->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>                                                      
               

                        <div class="product-action">
                            {{-- <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});" >
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>                             --}}

                            @if($relProduct->track_qty == 'Yes')
                                    @if ($relProduct->qty > 0)
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $relProduct->id }});">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a> 
                                    @else
                                        <a class="btn btn-dark" href="javascript:void(0);">
                                           Out Of Stock
                                        </a> 
                                    @endif                           
                            @else
                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $relProduct->id }});">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a> 
                            @endif
                        </div>
                    </div>                        
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="{{ route('front.product',$relProduct->slug)}}">{{ $relProduct->title }}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>${{ $relProduct->price }}</strong></span>
                            @if($relProduct->compare_price > 0)
                            <span class="h6 text-underline"><del>${{ $relProduct->compare_price }}</del></span>
                            @endif
                        </div>
                    </div>                        
                </div> 
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@endsection

@section('customJs')
<script type="text/javascript">
    $("#productRatingForm").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: '{{ route("front.saveRating",$product->id)}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                var errors = response.errors;

                if(response.status == false){
                    if(errors.name){
                        $("#name").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.name);
                    } else {
                        $("#name").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html("");
                    }

                    if(errors.email){
                        $("#email").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.email);
                    } else {
                        $("#email").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html("");
                    }

                    if(errors.comment){
                        $("#comment").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.comment);
                    } else {
                        $("#comment").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html("");
                    }     
                    
                    if(errors.rating){
                        $(".product-rating-error").html(errors.rating);
                    } else {
                        $(".product-rating-error").html('');
                    }          
                }
                else {
                    window.location.href="{{ route('front.product',$product->slug)}}";

                }   
            }
        });

    });
</script>
@endsection