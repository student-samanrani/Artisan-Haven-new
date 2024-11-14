@extends('front.layouts.app')

@section('content')
  <section class="container">
     <div class="col-md-12 text-center py-5">

        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>            
        @endif
        <h1>Thank you!</h1>
        <p>Your Order Is: {{ $id }}</p>
     </div>
  </section>
@endsection