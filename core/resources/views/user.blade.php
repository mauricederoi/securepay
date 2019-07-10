<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$page_title}} | {{$basic->sitename}}  </title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/x-icon">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
    <!-- pe icon  -->

    <link rel="stylesheet" href="{{asset('assets/front/css/pe-icon-7-stroke.min.css')}}">
    <!-- fontawesome icon  -->
    <link rel="stylesheet" href="{{asset('assets/front/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/animate.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('assets/front/css/owl.carousel.min.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/front/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{asset('assets/front/css/sweetalert.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/front/css/toastr.min.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/front/css/table.css')}}">
    <!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/custom.css')}}">
@yield('css')
    <link rel="stylesheet"  href="{{asset('assets/front/css/style.php')}}?color={{ $basic->color }}">
<!-- responsive -->
    <link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
</head>

<body>
{!! $basic->fb_comment !!}
<!-- top bar area start -->
<div class="topbar-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="topbar-inner"><!-- topbar inner start -->
                    <div class="topbar-left-content"><!-- topbar left content -->
                        <ul class="social-share">
                            @foreach($social as $data)
                                <li class="social-item">
                                    <a href="{!! $data->link !!}" class="social-link">
                                        {!! $data->code !!}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.topbar left content -->
                    <div class="topbar-right-content">
                        @include('partials.bell-notify')

                        <span class="ex-text">Balance : ₦{{number_format(Auth::user()->balance , $basic->decimal)}}</span>
                    </div>
                    <!-- topbar right content end-->
                </div><!-- topbar inner end -->
            </div>
        </div> <!-- row end -->
    </div><!-- container end -->
</div>
<!-- tp bar area end -->

<!-- support bar area start  -->
<section class="support-bar-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-12 col-md-3">
                <a href="{{url('')}}" class="logo">
                    <img src="{{asset('assets/images/logo/logo.png')}}" alt="logo"  class="max-logo-img"  style='max-width: 220px;'>
                </a>
            </div>
            <div class="col-lg-9 col-sm-12 col-md-9">
                <div class="support-bar-content"><!-- support bar content -->
                    <ul>
                        <li>
                            <div class="single-support-item"><!-- single support item -->
                                <div class="icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="content"><!-- content -->
                                    <h5>{!! $basic->phone !!}</h5>
                                    <a><span class="email">{!! $basic->email !!}</span></a>
                                </div><!-- /.content -->
                            </div><!-- /.single support item -->
                        </li>
                        <li>
                            <div class="single-support-item"><!-- single support item -->
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="content"><!-- content -->
                                    @php
                                        $split = explode(" ",  $basic->address);
                                    $lastSpacePosition = strrpos($basic->address," ");
                                    $textWithoutLastWord =substr($basic->address,0,$lastSpacePosition);
                                    @endphp

                                    <h5>{!! $textWithoutLastWord !!}</h5>
                                    <span class="loaction">{!! $split[count($split)-1] !!}</span>
                                </div><!-- /.content -->
                            </div><!-- /.single support item -->
                        </li>
                    </ul>
                </div><!-- /.support bar content -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</section>
<!-- support bar area end  -->

<!-- navbar area start -->
<nav class="navbar navbar-default navbar-area">
    <div class="container">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="nav-item  @if(request()->path() == 'user/home') active @endif">
                    <a class="nav-link" href="{{route('home')}}">My Dashboard </a>
                </li>
                
                <li class="nav-item  @if(request()->path() == 'user/add-escrow') active @endif">
                    <a class="nav-link" href="{{route('add.milestone')}}"></i>New Payment</a>
                </li>
                
                <li class="nav-item dropdown
                        @if(request()->path() == 'user/add-escrow') active
                        @elseif(request()->path() == 'user/escrow-list') active
                        @elseif(request()->path() == 'user/earning-list') active
                        @endif">
                    <a class="nav-link dropdown" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" href="">Manage Payment
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        
                        <li class="@if(request()->path() == 'user/escrow-list') active @endif">
                            <a href="{{route('escrow.list')}}"> <i class="fas fa-list-ul"></i>My Payment List </a></li>
                        <li class="@if(request()->path() == 'user/earning-list') active @endif">
                            <a href="{{route('earn.list')}}"> <i class="fas fa-hand-holding-usd"></i>My Earnings </a></li>
                        <li class="@if(request()->path() == 'user/transaction-log') active @endif">
                            <a href="{{route('user.trx')}}"> <i class="far fa-chart-bar"></i>Transaction Log </a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown
                        @if(request()->path() == 'user/deposit') active
                        @elseif(request()->path() == 'user/deposit-log') active
                        @endif">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"  href="">Deposit Funds
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="@if(request()->path() == 'user/deposit') active @endif">
                            <a href="{{route('deposit')}}"><i class="fas fa-money-bill-wave"></i>Make Deposit</a></li>
                        <li class="@if(request()->path() == 'user/deposit-log') active @endif">
                            <a href="{{route('user.depositLog')}}"><i class="fas fa-history"></i>Deposit History</a></li>
                    </ul>
                </li>


                <li class="nav-item dropdown
                        @if(request()->path() == 'user/withdraw-money') active
                        @elseif(request()->path() == 'user/withdraw-log') active
                        @endif">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" href="">Withdraw Funds
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="@if(request()->path() == 'user/withdraw-money') active @endif">
                            <a href="{{route('withdraw.money')}}"> <i class="fas fa-money-bill-wave"></i>Make Withdrawals</a></li>
                        <li class="@if(request()->path() == 'user/withdraw-log') active @endif">
                            <a href="{{route('user.withdrawLog')}}"><i class="fas fa-list-ol"></i>Withdrawal History</a></li>
                    </ul>
                </li>




                <li class="nav-item dropdown
                        @if(request()->path() == 'user/edit-profile') active
                        @elseif(request()->path() == 'user/change-password') active
                        @endif">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" href="">Hi {{ Auth::user()->username }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="@if(request()->path() == 'user/edit-profile') active @endif">
                            <a href="{{route('edit-profile')}}"><i class="fas fa-users"></i>Edit Profile</a></li>
                        <li class="@if(request()->path() == 'user/change-password') active @endif">
                            <a href="{{route('user.change-password')}}"><i class="fas fa-lock"></i>Change Password</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>Log Out</a></li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
    <div class="mobile-logo-wrapper disable-desktop">
        <a href="#" class="logo">
            <img src="{{asset('assets/images/logo/logomobile.png')}}" alt="logo"  style='max-width: 220px;'>
        </a>
    </div>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1"
            aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span><a/>
    </button>
</nav>
<!-- navbar area end -->

@yield('content')

@include('partials.footer')


<!-- jquery -->
<script src="{{asset('assets/front/js/jquery.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
<!-- owl carousel -->
<script src="{{asset('assets/front/js/owl.carousel.min.js')}}"></script>
<!-- magnific popup -->
<script src="{{asset('assets/front/js/jquery.magnific-popup.js')}}"></script>
<!-- way poin js-->
<script src="{{asset('assets/front/js/waypoints.min.js')}}"></script>
<!-- wow js-->
<script src="{{asset('assets/front/js/wow.min.js')}}"></script>
<!-- counterup js-->
<script src="{{asset('assets/front/js/jquery.counterup.min.js')}}"></script>

<script src="{{asset('assets/front/js/sweetalert.js')}}" ></script>
<script src="{{asset('assets/front/js/toastr.min.js')}}" ></script>
@yield('script')
<!-- main -->
<script src="{{asset('assets/front/js/main.js')}}"></script>
@yield('js')
@include('partials.alert-js')
<script>
            @if(Session::has('message'))
    var type = "{{Session::get('alert-type','info')}}";
    switch (type) {
        case 'info':
            toastr.info("{{Session::get('message')}}");
            break;
        case 'warning':
            toastr.warning("{{Session::get('message')}}");
            break;
        case 'success':
            toastr.success("{{Session::get('message')}}");
            break;
        case 'error':
            toastr.error("{{Session::get('message')}}");
            break;
    }
    @endif

</script>
</body>

</html>