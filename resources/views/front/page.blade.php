@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item">{{ $page->name }}</li>
            </ol>
        </div>
    </div>
</section>
@if ($page->slug == 'contact-us')
<section class=" section-10">
    <div class="container">
        <div class="section-title mt-5 ">
            <h2> {!! $page->name !!}  </h2>
        </div>   
    </div>
</section>
<section>
    <div class="container">          
        <div class="row">
           <div class="col-md-12">
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>            
            @endif
           </div>
            <div class="col-md-6 mt-3 pe-lg-5">
                  {!! $page->content !!}                 
            </div>

            <div class="col-md-6">
                <form class="shake" role="form" method="post" id="contactForm" name="contactForm">
                    <div class="mb-3">
                        <label class="mb-2" for="name">Name</label>
                        <input class="form-control" id="name" type="text" name="name"  data-error="Please enter your name">
                        <p class="help-block with-errors"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="mb-2" for="email">Email</label>
                        <input class="form-control" id="email" type="email" name="email"  data-error="Please enter your Email">
                        <p class="help-block with-errors"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="mb-2">Subject</label>
                        <input class="form-control" id="subject" type="text" name="subject"  data-error="Please enter your message subject">
                        <p class="help-block with-errors"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="mb-2">Message</label>
                        <textarea class="form-control" rows="3" id="message" name="message"  data-error="Write your message"></textarea>
                        <p class="help-block with-errors"></p>
                    </div>
                  
                    <div class="form-submit">
                        <button class="btn btn-dark" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@elseif ($page->slug == 'about-us')
<section class=" section-10">
    <div class="container">
        <div class="section-title mt-5 ">
            <h2> {!! $page->name !!}  </h2>
        </div>   
    </div>
</section>
<section>
    <div class="container">          
        <div class="row">
            <div class="col-md-12 pb-5">
                  {!! $page->content !!}                 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <picture>
                    <img src="{{ asset('front-assets/images/about.jpg')}}" alt="" />
                </picture>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-5">
                <p class="lead" style="text-align:justify;"> Our mission is to connect art lovers with exceptional, one-of-a-kind creations that transcend time.
                     Artisan Haven provides an immersive experience where visitors can explore, appreciate, and purchase artwork that speaks to their heart. 
                     From vibrant canvases to elegant calligraphy, every item on our platform brings a personal touch to your space.
                     When you purchase from Artisan Haven, you're not just acquiring a product—you're supporting the preservation of artistic traditions and empowering artisans to continue creating timeless works of art for generations to come.
                </p >
            </div>
        </div>
    </div>
</section>

@else
<section class=" section-10">
    <div class="container">
        <h1 class="my-3 text-center">{{ $page->name }}</h1>
        {!! $page->content !!}
    </div>
</section> 
@endif
@endsection

@section('customJs')
<script>
    $("#contactForm").submit(function(event){
        event.preventDefault();

    $("#form-submit").prop('disabled',true);


        $.ajax({
            url: '{{ route("front.sendContactEmail")}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $("#form-submit").prop('disabled',false);
                    

                    window.location.href="{{ route('front.page',$page->slug)}}";

                } else {
                     var errors = response.errors;

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

                    if(errors.subject){
                        $("#subject").addClass('is-invalid')
                        .siblings("p")
                        .addClass('invalid-feedback')
                        .html(errors.subject);
                    } else {
                        $("#subject").removeClass('is-invalid')
                        .siblings("p")
                        .removeClass('invalid-feedback')
                        .html("");
                    }
                }
            }
        });

    });
</script>
@endsection