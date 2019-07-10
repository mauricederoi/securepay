@extends('user')
@section('content')
    <!-- about area start -->
    <section class="about-us-aera">
        <div class="container">
            <div class="row text-center">

                <div class="col-lg-4 col-md-4 col-sm-6 col-rm-6">
                    <div class="single-about-box about-box-bg-1"><!-- single about box -->
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="content">
                            <h4 class="title">Balance : ₦{{number_format(Auth::user()->balance)}}</h4>
                        </div>
                    </div><!-- //. single about box -->
                    <br>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-rm-6">
                    <a href="{{route('escrow.list')}}">
                    <div class="single-about-box about-box-bg-1 rmb-30"><!-- single about box -->
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="content">
                            <h4 class="title">My Payment List</h4>
                            <p class="descr">{{$myEscrowList}} members</p>
                        </div>
                    </div><!-- //. single about box -->
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-rm-6">
                    <a href="{{route('earn.list')}}">
                    <div class="single-about-box about-box-bg-1 rmb-30"><!-- single about box -->
                        <div class="icon">
                            <i class="fa fa-users-cog"></i>
                        </div>
                        <div class="content">
                            <h4 class="title"> My Earnings</h4>
                            <p class="descr">{{$myEarnList}} members</p>
                        </div>
                    </div><!-- //. single about box -->
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- about area end -->



@stop