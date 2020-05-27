@extends('coupon::index')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center h-100">
        <div class="col-12 my-auto">
            <div class="@if ($message = Session::get('success')) alert-success @endif" style="min-height: 50px;">
                @if ($message = Session::get('success'))
                <span>{{$message}}</span>
                @endif
            </div>
            <div class="card shadow mb-4">
                <div class="card-body b-shadow">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Coupon code</th>
                                    <th class="text-center">restricted to</th>
                                    <th class="text-center">Usage Restriction</th>
                                    <th class="text-center">No. of times used</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Expiry</th>
                                    <th class="text-center">Validity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($coupons as $key => $coupon)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-center">{{$coupon->coupon_code}}</td>
                                    <td class="text-center">{{ucfirst(trans($coupon->restricted_to))}} Usage</td>
                                    <td class="text-center">
                                        @if ($coupon->no_of_usage_unlimited == false)
                                        {{$coupon->no_of_usage_int}}
                                        @else
                                        Unlimited
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $coupon->timesUsed()}}</td>
                                    <td class="text-center">
                                        @if ($coupon->discount_percentage != null)
                                        {{$coupon->discount_percentage}}%
                                        @else
                                        {!!Get_currency()!!}{{number_format($coupon->discount_fixed_amount)}}
                                        @endif
                                    </td>
                                    <td class="text-center">{{$coupon->expiry->format('Y-m-d')}} at {{$coupon->expiry->format('H:ia')}}</td>
                                    <td class="text-center">{{$coupon->validity()}}</td>
                                    <td id="actionBtn" class="text-center margin: auto 0;">
                                        <a href="/coupon/generate?code={{$coupon->coupon_code}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection