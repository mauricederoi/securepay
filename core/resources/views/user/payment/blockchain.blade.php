@extends('user')
@section('content')
	<div class="get-in-touch-area cotnact-page">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-primary panel-custom">
						<div class="panel-heading text-center">
							<h4 class="name">{{$page_title}} </h4>
						</div>

						<div class="panel-body text-center">

						<h3 class="text-color"> PLEASE SEND EXACTLY <span style="color: green"> {{ $bitcoin['amount'] }}</span> BTC</h3>
							<h5>TO <span style="color: green"> {{ $bitcoin['sendto'] }}</span></h5>
							{!! $bitcoin['code'] !!}
							<h4 class="text-color bold">SCAN TO SEND</h4>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>




@endsection