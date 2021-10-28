@extends('admin.master',['menu'=>'users','sub_menu'=>'user'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('User management')}}</li>
                    <li class="active-item">{{__('User Profile')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <!-- User Management -->
    <div class="user-management profile">
        <div class="row">
            <div class="col-12">
                <div class="profile-info padding-40">
                    <div class="row">
                        <div class="col-xl-4 mb-xl-0 mb-4">
                            <div class="user-info text-center">
                                <div class="avater-img">
                                    <img src="{{show_image($user->id,'user')}}" alt="">
                                </div>
                                <h4>{{$user->first_name.' '.$user->last_name}}</h4>
                                <p>{{$user->email}}</p>
                                <p class="cp-user-btc">
                                    @if(!empty($clubInfos['club_id']))
                                        <span>
                                            <img src="{{ $clubInfos['plan_image'] }}" class="img-fluid" alt="">
                                        </span>
                                        {{ $clubInfos['plan_name'] }}
                                    @endif
                                </p>
                                {{-- <div class="cp-user-available-balance-profile">
                                    <p>{{__('Blocked Coin')}} <span>{{number_format(get_blocked_coin($user->id),2)}}</span> {{allsetting('coin_name')}}</p>
                                </div> --}}
                            </div>
                            <ul class="profile-transaction">
                                <li class="profile-deposit" style="width: 100% !important;">
                                    <p>{{__('Total Topup')}}</p>
                                    <h4>Rp. {{number_format(total_topup($user->id), 0)}}</h4>
                                </li>
                                {{-- <li class="profile-withdrow">
                                    <p>{{__('Total Withdrawal')}}</p>
                                    <h4>{{total_withdrawal($user->id) }} {{ settings('coin_name') }}</h4>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="col-xl-8">
                            <div class="profile-info-table">
                                <ul>
                                    <li>
                                        <span>{{__('Name')}}</span>
                                        <span class="dot">:</span>
                                        <span><strong>{{$user->first_name.' '.$user->last_name}}</strong></span>
                                    </li>
                                    <li>
                                        <span>{{__('Role')}}</span>
                                        <span class="dot">:</span>
                                        <span><strong>{{userRole($user->role)}}</strong></span>
                                    </li>
                                    <li>
                                        <span>{{__('Email')}}</span>
                                        <span class="dot">:</span>
                                        <span><strong>{{$user->email}}</strong></span>
                                    </li>
                                    <li>
                                        <span>{{__('Email Verification')}}</span>
                                        <span class="dot">:</span>
                                        <span class=""><strong>{{statusAction($user->is_verified)}}</strong></span>
                                    </li>
                                    <li>
                                        <span>{{__('Contact')}}</span>
                                        <span class="dot">:</span>
                                        <span><strong>{{$user->phone}}</strong></span>
                                    </li>
                                    <li>
                                        <span>{{__('Active Status')}}</span>
                                        <span class="dot">:</span>
                                        <span>{{statusAction($user->status)}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->
@endsection

@section('script')

@endsection
