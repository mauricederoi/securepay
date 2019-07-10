@extends('layout')
@section('content')
    <!-- header area start -->
    <section class="header-area ">
        <div class="header-inner" id="header-carousel">
            @foreach($sliders as $data)
                <div class="single-slider-item"
                     style="background-size:cover;background-position:center;background-image: url(assets/images/slider/{{$data->image}});">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                                <h1 class="title text-center">{!! $data->title !!}</h1>
                                <p>{!! $data->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- header area end -->

    <!-- about area start -->
    <section class="about-us-aera about-page">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="right-content-area">
                        {!! $basic->about !!}
                    </div>
                </div>
            </div>
        </div>
		<div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="left-content-area">
                        <div class="thumb">
                            <img src="{{asset('assets/images/about-video-image.jpg')}}" alt="about left image">
                            <div class="hover">
                                <a href="{!! $basic->	about_video !!}" class="mfp-iframe video-play-btn">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
    </section>
    <!-- about area end -->

    <!-- counter and subscribe area start -->
    <section class="counter-and-subscribe-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-rm-6">
                    <div class="single-counter-box"><!-- single counter box -->
                        <div class="bg-icon"><i class="pe-7s-users"></i></div>
                        <div class="counter-number">
                            <span class="count-numb">{{785}}</span>
                        </div>
                        <h4 class="name">Users</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-rm-6">
                    <div class="single-counter-box rrmt-30">
                        <!-- single counter box -->
                        <div class="bg-icon two"><i class="pe-7s-news-paper"></i></div>
                        <div class="counter-number">
                            <span class="count-numb">{{5}}</span>
                        </div>
                        <h4 class="name">Blog</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-rm-6">
                    <div class="single-counter-box rmt-30">
                        <!-- single counter box -->
                        <div class="bg-icon three"><i class="pe-7s-like2"></i></div>
                        <div class="counter-number">
                            <span class="count-numb">{{42}}</span>
                        </div>
                        <h4 class="name">Subscribers</h4>
                    </div>
                    <!-- //. single counter box -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="subscribe-outer-wrapper"><!-- subscribe form wrapper -->
                        <h2 class="title">Subscribe for <strong>more updates</strong></h2>
                        <div class="subscribe-form-wrapper">
                            <form action="{{route('subscribe')}}" method="post">
                                @csrf
                                <div class="form-element">
                                    <input name="email" type="email" placeholder="Enter your email address" class="input-field">
                                </div>
                                <input type="submit" value="subscribe" class="submit-btn">
                            </form>
                        </div>
                    </div><!-- subscribe form wrapper -->
                </div>
            </div>
        </div>
    </section>
    <!-- counter and subscribe area end -->

    <!-- news feed area start -->
    
    <!-- news feed area end -->
   



@stop

@section('script')

@stop