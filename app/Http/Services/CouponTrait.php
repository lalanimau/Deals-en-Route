<?php

namespace App\Http\Services;

use App\Coupon;
use App\CouponShare;
use Auth;
use Carbon\Carbon;
use App\User;

trait CouponTrait {

    //get count of friend list
    public function getCouponShareCount($activityid = "", $couponid) {
        if (empty($activityid)) {
            return CouponShare::where(['coupon_id' => $couponid])
                            ->where(function($q) {
                                $q->where(['user_id' => Auth::id()])
                                ->orWhere('share_friend_id', Auth::id());
                            })
                            ->count();
        }
        return CouponShare::where(['user_id' => Auth::id()])
                        ->where(['coupon_id' => $couponid])
                        ->where(['activity_id' => $activityid])
                        ->count();
    }

    public function getCouponShareFriend($couponid) {
        $coupon_share = CouponShare::select('share_friend_id as user_id')->where('user_id', Auth::id())
                ->where('coupon_id', $couponid)
                ->get()
                ->toArray();

        $coupon_owner = CouponShare::select('user_id as user_id')->where('share_friend_id', Auth::id())
                ->where('coupon_id', $couponid)
                ->get()
                ->toArray();


        return array_merge($coupon_share, $coupon_owner);
    }

    public function finalMessage($message, $item) {

        $find = ['{{coupon_name}}', '{{count}}', '{{created_by}}'];
        $replace = [$item->coupon->coupon_name, $item->count_fb_friend, $item->user->first_name . " " . $item->user->last_name];
        $message = str_replace($find, $replace, $message);
        return $message;
    }
    
    
    public static function convertDateInUtc($date){
      
      $date = Carbon::parse($date);
      $authtimezone=User::find(Auth::id())->vendorDetail->vendor_time_zone;  
      if (strpos($authtimezone, '-') !== false) {
          $timezone=str_replace('-','',$authtimezone); 
          $finalDate=$date->subMinutes($timezone);  
      }else if (strpos($date, '+') !== false) {
          $timezone=str_replace('+','',$authtimezone); 
          $finalDate=$date->addMinutes($timezone);  
      }else{
          $finalDate=$date;
      }
        return   $finalDate;
    }
    
    
    public static function convertDateInUserTZ($date){
      
      $date = Carbon::parse($date);
      $authtimezone=User::find(Auth::id())->vendorDetail->vendor_time_zone;  
      if (strpos($authtimezone, '-') !== false) {
          $timezone=str_replace('-','',$authtimezone); 
          $finalDate=$date->addMinutes($timezone);  
      }else if (strpos($date, '+') !== false) {
          $timezone=str_replace('+','',$authtimezone); 
          $finalDate=$date->subMinutes($timezone);  
      }else{
          $finalDate=$date;
      }
        return   $finalDate;
    }
    
    
    

}
