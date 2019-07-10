@extends('user')
@section('content')
    <!-- get in touch area start -->
    <div class="get-in-touch-area cotnact-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-col-padding">

                    <div class="panel panel-primary panel-custom "><!-- single pricing table -->
                        <div class="panel-heading ">
                            <h4 class="name">Deposits </h4>
                        </div>
                        <div class="panel-body">
                            <div class="contact-form-wrapper">
                                <table class="table table-default table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Transaction ID</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(count($invests) >0)
                                        @foreach($invests as $k=>$data)
                                            <tr>
                                                <td data-label="SL">{{++$k}}</td>
                                                <td data-label="#Trx">{{$data->trx or 'N/A'}}</td>
                                                <td data-label="Details">{!! $data->gateway->name  or 'N/A' !!}</td>
                                                <td data-label="Amount">{!! $data->amount  or 'N/A' !!} {!! $basic->currency !!}</td>
                                                <td data-label="Time">
                                                    {!! date(' d M, Y h:s A', strtotime($data->created_at)) !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5"> You don't have any deposit history !!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- //.content form wrapper -->

                            <div class="post-navigation">
                                <ul class="pagination">
                                    {{ $invests->links('partials.pagination') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- get in touch area end -->


@stop