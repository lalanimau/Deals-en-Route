<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Http\Services\CouponTrait;
use App\Coupon;
use App\Http\Services\ResponseTrait;

class HomeController extends Controller {

    use CouponTrait;
    use ResponseTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth.vendor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $coupon_lists = \App\Coupon::couponList();
        $vendor_detail = \App\VendorDetail::join('stripe_users', 'stripe_users.user_id', 'vendor_detail.user_id')
                ->where('vendor_detail.user_id', Auth::id())
                ->first();
        $country_list = \App\Country::countryList();
        $date= \Carbon\Carbon::now();
        $currenttime=$this->convertDateInUserTZ($date);
        $year =$this->getLastYear();

       
        return view('frontend.dashboard.main')->with(['coupon_lists' => $coupon_lists,
                    'vendor_detail' => $vendor_detail, 'country_list' => $country_list,
            'currenttime'=>$currenttime,'year'=>$year]);
    }

    public function dashboard(Request $request){
        $request=$request->all();
        $year=(isset($request) && !empty($request['year']))?$request['year']:date('Y'); 
        $month=(isset($request) && !empty($request['month']))?$request['month']:date('m'); 
        $data = [];
        $total_redeem_monthly = Coupon::getReedemCouponMonthly($year);
        $total_redeem_weekly = Coupon::getReedemCouponWeekly($year,$month);
        $total_coupon_monthly = Coupon::getTotalCouponMonthly();
        $total_active_coupon_monthly = Coupon::getTotalActiveCouponMonthly();
        $total_age_wise_redeem= \App\CouponRedeem::getAgeWiseReddemCoupon();
        $data['total_redeem_monthly'] = $total_redeem_monthly->getAttributes();
        $data['total_coupon_monthly'] = $total_coupon_monthly->getAttributes();
        $data['total_redeem_weekly'] = $total_redeem_weekly->getAttributes();
        $data['total_active_coupon_monthly'] = $total_active_coupon_monthly->getAttributes();
        $data=$data+$total_age_wise_redeem;
        return $this->responseJson('success', \Config::get('constants.DASHBOARD_DETAIL'), 200, $data);
    }

}
