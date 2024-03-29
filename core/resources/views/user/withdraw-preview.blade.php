@extends('user')
@section('content')


    <div class="get-in-touch-area cotnact-page">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                        <div class="panel panel-primary panel-custom">
                            <div class="panel-heading text-center">
                                <h4 class="name">{{ $method->name }}</h4>
                            </div>
                            <div style="font-size: 18px;padding: 18px;" class="panel-body text-center">
                                <img class="" style="width: 35%;border-radius: 5px"
                                     src="{{ asset('assets/images') }}/{{ $method->image }}" alt="">
                            </div>
                            <ul style='font-size: 15px;' class="list-group text-center bold">
                                <li class="list-group-item">Limit - ( {!! $method->withdraw_min !!}
                                    to {{ $method->withdraw_max }} ) {{ $basic->currency }} </li>
                                <li class="list-group-item"> Fix Charge - {{ $method->fix }} {{ $basic->currency }}</li>
                                <li class="list-group-item"> Percentage - {{ $method->percent }}%</li>
                                <li class="list-group-item">Duration - {!! $method->duration !!} Days</li>
                            </ul>
                            <div class="panel-footer" style="overflow: hidden">
                                <div class="col-sm-12">
                                    <a href="{{ route('withdraw.money') }}"
                                       class="btn bold uppercase custom-sbtn btn-primary btn-block "><i
                                                class="fa fa-arrow-left"></i> Another Method</a>
                                </div>

                            </div>
                        </div>

                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="panel panel-primary panel-custom">
                        <div class="panel-heading">
                            <h4 class="name">Withdraw Preview</h4>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="text-center">
                                <h3 class="bold uppercase">Current Balance :N<strong>{{number_format( $balance->balance, $basic->decimal) }}</strong></h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group">
                                    <label style="margin-top: 5px;font-size: 14px;"
                                           class="col-sm-4 col-sm-offset-1 bold uppercase text-right control-label">Amount Requested : </label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" value="{{ number_format($withdraw->amount) }}" readonly name="amount"
                                                   id="amount" class="form-control bold"
                                                   placeholder="Enter Deposit Amount" required>
                                            <span class="input-group-addon ">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label style="margin-top: 5px;font-size: 14px;"
                                           class="col-sm-4 col-sm-offset-1 text-right bold uppercase control-label">Withdrawal
                                        Charges : </label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" value="{{ number_format(round($withdraw->charge,$basic->decimal) )}}"
                                                   readonly name="charge" id="charge" class="form-control bold"
                                                   placeholder="Enter Deposit Amount" required>
                                            <span class="input-group-addon ">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group">
                                    <label style="margin-top: 5px;font-size: 14px;"
                                           class="col-sm-4 col-sm-offset-1 bold uppercase text-right control-label">Total
                                        Amount : </label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" value="{{ number_format($withdraw->net_amount) }}" readonly
                                                   name="charge" id="charge" class="form-control bold"
                                                   placeholder="Enter Deposit Amount" required>
                                            <span class="input-group-addon">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label style="margin-top: 5px;font-size: 14px;"
                                           class="col-sm-4 col-sm-offset-1 bold uppercase text-right control-label">Available
                                        Balance : </label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" value="{{ number_format($balance->balance - $withdraw->net_amount) }}"
                                                   readonly name="charge" id="charge" class="form-control bold"
                                                   placeholder="Enter Deposit Amount" required>
                                            <span class="input-group-addon ">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary panel-custom" data-collapsed="0">
                        <!-- to apply shadow add class "panel-shadow" -->

                        <!-- panel head -->
                        <div class="panel-heading">
                            <div class="panel-title"><i class="fa fa-send"></i> <strong>Account Details</strong>
                            </div>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="col-md-12">

                                <form method="post" action="{{route('withdraw.submit')}}" onsubmit="disableWithdrawButton()">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="withdraw_id" value="{{ $withdraw->id }}">
                                    <div class="row">
                                        <div class="col-md-6">

                                                        <textarea name="send_details" rows="4"
                                                                  class="form-control bold input-lg"
                                                                  placeholder="Bank Account Details" required></textarea>
                                        </div>

                                        <div class="col-md-6">
                                                         <textarea name="message" rows="4"
                                                                   class="form-control bold input-lg"
                                                                   placeholder="Remarks/Additional Information (optional)"></textarea>
                                        </div>

                                        <div class="col-md-12" style="margin-top:30px;">
                                            <button type="submit" id="withdraw_btn" 
                                                    class="btn btn-primary bold btn-lg custom-sbtn uppercase btn-block"><i
                                                        class="fa fa-send"></i> Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- About Hostonion End -->


    <script type="text/javascript">
        disableWithdrawButton = () => {
            $('#withdraw_btn').attr('disabled', true)
        }
    </script>

@stop