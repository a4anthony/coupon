@extends('coupon::index')

@section('content')

<div class="container">
    <div class="row justify-content-center" style="min-height: 90vh;">
        <div class="col-6 my-auto">
            <div class="card shadow mb-4">
                <div class="card-header">
                    @if(isset($_GET['code']))
                    {{ __('Update Coupon') }}
                    @else
                    {{ __('Generate Coupon') }}
                    @endif
                </div>

                <div class="card-body  b-shadow">
                    <form method="POST" action="@if(isset($_GET['code'])) {{ route('coupon.update') }} @else {{ route('coupon.store') }} @endif">
                        @csrf
                        @if(isset($_GET['code']))
                        @method('PUT')
                        @endif
                        <div class="row">
                            <!-- coupon prefix start -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="prefix" class="col-form-label text-md-right">{{ __('Coupon Prefix') }}</label>
                                    <input type="text" name="coupon_code" hidden value="{{ $coupon->coupon_code ?? '' }}">
                                    <input id="prefix" type="text" class="form-control @error('prefix') is-invalid @enderror" placeholder="Enter coupon prefix" name="prefix" value="{{ old('prefix', $coupon->prefix ?? '') }}" required @if(isset($_GET['code'])) readonly @endif>
                                    @error('prefix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- coupon prefix end -->
                            <!-- coupon restriction start -->
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="restrictions" class="col-form-label text-md-right">{{ __('Coupon Restriction') }}</label>
                                    <select name="restrictions" class="form-control @error('restrictions') is-invalid @enderror" id="restrictions">
                                        <option value="">-- Select restriction --</option>
                                        <option value="multiple" {{ old('restrictions', $coupon->restricted_to ?? '') == 'multiple' ? 'selected' : '' }}>Multiple usage by single user</option>
                                        <option value="single" {{ old('restrictions', $coupon->restricted_to ?? '') == 'single' ? 'selected' : '' }}>Single usage by single user</option>
                                    </select>
                                    @error('restrictions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- coupon restriction end -->
                            <!-- coupon usage start -->
                            <div class="col-12">
                                <div class="form-group ">
                                    <label for="usage" class="col-form-label text-md-right">{{ __('No. of Usage') }}</label>
                                    <div class="row">
                                        <div class="col-5 text-center">
                                            <input id="usage_amount" type="number" @if($coupon->no_of_usage_unlimited ?? '' == true) disabled @endif placeholder="Enter value" class="form-control @error('usage_amount') is-invalid @enderror" name="usage_amount" value="{{ old('usage_amount',$coupon->no_of_usage_int ?? '') }}" >
                                            @error('usage')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-2 text-center my-auto">
                                            <h5>OR</h5>
                                        </div>
                                        <div class="col-5 text-center my-auto">
                                            <input class="form-check-input" type="checkbox" name="usage_unlimited" id="usage_unlimited" {{ old('usage_unlimited', $coupon->no_of_usage_unlimited ?? '') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="usage_unlimited">
                                                {{ __('Unlimited usage') }}
                                            </label>
                                        </div>
                                    </div>
                                    <input name="usage" hidden class="form-control @error('usage') is-invalid @enderror">
                                    @error('usage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- coupon usage end -->
                            <!-- cupon discount start -->
                            <div class="col-12">
                                <div class="form-group ">
                                    <label for="discount" class="col-form-label text-md-right">{{ __('Coupon Discount') }}</label>
                                    <div class="row">
                                        @if ($coupon->discount_percentage ?? '' != null)
                                        @php
                                        $discount = $coupon->discount_percentage ?? '';
                                        $discount_type = 'percent';
                                        @endphp
                                        @elseif ($coupon->discount_fixed_amount ?? '' != null)
                                        @php
                                        $discount = $coupon->discount_fixed_amount ?? '';
                                        $discount_type = 'amount';
                                        @endphp
                                        @endif
                                        <div class="col-6 text-center">
                                            <select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror" id="discount_type">
                                                <option value="">-- Select discount type --</option>
                                                <option value="percent" {{ old('discount_type', $discount_type ?? '') == 'percent' ? 'selected' : '' }}>By percentage</option>
                                                <option value="amount" {{ old('discount_type', $discount_type ?? '') == 'amount' ? 'selected' : '' }}>By fixed amount</option>
                                            </select>
                                        </div>
                                        <div class="col-6 text-center">
                                            <input id="discount" type="number" placeholder="Enter value" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount',$discount ?? '') }}" required>
                                            @error('discount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <label for="prefix" class="col-form-label text-md-right">{{ __('Set Expiry') }}</label>
                                    <input type='text' name="expiry" data-date-format="YYYY-M-D H:mmA" value="{{$coupon->expiry ?? ''}}" id="expiry" placeholder="Set expiry date and time" class="form-control" />

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-primary">
                                        @if(isset($_GET['code']))
                                        {{ __('Update Coupon') }}
                                        @else
                                        {{ __('Generate Coupon') }}
                                        @endif
                                    </button>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-delete" data-toggle="modal" data-target="#exampleModal">
                                        @if(isset($_GET['code']))
                                        {{ __('Delete Coupon') }}
                                        @else
                                        @endif
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this coupon and all it's records?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" id="delete-btn" class="btn btn-primary btn-delete">
                                                        @if(isset($_GET['code']))
                                                        {{ __('Delete Coupon') }}
                                                        @else
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($_GET['code']))
<form id="delete-coupon-form" action="{{route('coupon.delete')}}" method="POST">
    @csrf
    @method('DELETE')
    <input type="text" name="coupon_code" hidden value="{{$_GET['code']}}">
</form>
@endif
@endsection