<?php

namespace App\Http\Transformer;

use URL;
use Carbon\Carbon;

class CouponTransformer {

    public function transformList($coupon) {
        $var = [];
        $var = $coupon->map(function ($item) {
            return [
                'coupon_id' => $item->coupon_id ?? '',
                'coupon_category_name' => $item->categoryDetail->category_name ?? '',
                'coupon_original_price' => $item->coupon_original_price ?? 0,
                'coupon_total_discount' => $item->coupon_total_discount ?? 0,
                'coupon_name' => $item->coupon_name ?? '',
                'vendor_name' => $item->vendorDetail->vendor_name ?? '',
                'vendor_address' => $item->vendorDetail->vendor_street_address ?? '',
                'coupon_detail' => $item->coupon_detail ?? '',
                'remaining_coupons' => $item->remaining_coupons ?? '',
                'coupon_code' => $item->coupon_code ?? '',
                'coupon_end_date' => $item->coupon_end_date ?? '',
                'coupon_likes' => $item->total_likes ?? '',
                'vendor_ratings' => $item->vendor_ratings ?? '',
                'is_liked' => $item->is_liked ?? '',
                'coupon_comments' => $item->total_comments ?? '',
                'distance' => number_format($item->distance, 1) ?? '',
                'vendor_id' => $item->vendorDetail->user_id ?? '',
                'vendor_logo' => $item->vendorDetail->vendor_logo ?? '',
                'category_logo_image' => $item->categoryDetail->category_logo_image ?? "",
                'coupon_start_date' => $item->coupon_start_date ?? '',
                'coupon_end_date' => $item->coupon_end_date ?? '',
//                'is_favorite' => (empty($item->couponFavDetail)) ? 0 : $item->couponFavDetail->is_favorite,
                'coupon_lat' => $item->coupon_lat ?? '',
                'coupon_long' => $item->coupon_long ?? ''
            ];
        });

        return ['has_page' => $coupon->hasMorePages(), 'current_page' => $coupon->currentPage(), 'listing' => $var];
    }

    public function transformFavSearchList($coupon) {

        $var = [];
        $var = $coupon->map(function ($item) {

            return [
                'coupon_id' => $item->coupon_id ?? '',
                'coupon_category_name' => $item->categoryDetail->category_name ?? '',
                'coupon_original_price' => $item->coupon_original_price ?? 0,
                'coupon_total_discount' => $item->coupon_total_discount ?? 0,
                'coupon_name' => $item->coupon_name ?? '',
                'vendor_name' => $item->vendorDetail->vendor_name ?? '',
                'vendor_address' => $item->vendorDetail->vendor_street_address??'',
                'coupon_detail' => $item->coupon_detail ?? '',
                'remaining_coupons' => $item->remaining_coupons ?? '',
                'coupon_code' => $item->coupon_code ?? '',
                'coupon_end_date' => $item->coupon_end_date ?? '',
                'coupon_likes' => $item->total_likes ?? '',
                'vendor_ratings' => $item->vendor_ratings ?? '',
                'is_liked' => $item->is_liked ?? '',
                'coupon_comments' => $item->total_comments ?? '',
                'distance' => number_format($item->distance, 1) ?? '',
                'vendor_logo' => $item->vendorDetail->vendor_logo ?? '',
                'category_logo_image' => $item->categoryDetail->category_logo_image ?? "",
                'coupon_start_date' => $item->coupon_start_date ?? '',
        
//                'is_favorite' => (empty($item->couponFavDetail)) ? 0 : $item->couponFavDetail->is_favorite,
                'coupon_lat' => $item->coupon_lat ?? '',
                'coupon_long' => $item->coupon_long ?? '',
                'vendor_id' => $item->vendorDetail->user_id ?? '',
            ];
        });
        return ['has_page' => $coupon->hasMorePages(), 'current_page' => $coupon->currentPage(), 'listing' => $var];
    }

    public function transformDetail($item) {

        return [
            'coupon_id' => $item->coupon_id ?? '',
            'coupon_category_name' => $item->categoryDetail->category_name ?? '',
            'category_logo_image' => $item->categoryDetail->category_logo_image ?? "",
            'vendor_logo' => $item->vendorDetail->vendor_logo ?? '',
            'coupon_original_price' => $item->coupon_original_price ?? 0,
            'coupon_total_discount' => $item->coupon_total_discount ?? 0,
            'vendor_name' => $item->vendorDetail->vendor_name ?? '',
            'vendor_address' => $item->vendorDetail->vendor_street_address ?? '',
            'coupon_name' => $item->coupon_name ?? '',
            'coupon_code' => $item->coupon_code ?? '',
            'coupon_detail' => $item->coupon_detail ?? '',
              'coupon_start_date' => $item->coupon_start_date ?? '',
            'coupon_qrcode_image' => $item->coupon_qrcode_image ?? '',
            'coupon_redemption_code' => $item->coupon_code ?? '',
            'coupon_end_date' => $item->coupon_end_date ?? '',
             'coupon_comments' => $item->total_comments ?? '',
              'is_liked' => $item->is_liked ?? '',
//            'is_favorite' => (empty($item->couponFavDetail)) ? 0 : $item->couponFavDetail->is_favorite,
            'coupon_lat' => $item->coupon_lat ?? '',
             'coupon_likes' => $item->total_likes ?? '',
            'coupon_long' => $item->coupon_long ?? '',
            'vendor_id' => $item->vendorDetail->user_id ?? '',
             'vendor_ratings' => $item->vendor_ratings ?? '',
              'distance' => number_format($item->distance, 1) ?? '',
             'remaining_coupons' => $item->remaining_coupons ?? '',
        ];

        return ['has_page' => $coupon->hasMorePages(), 'current_page' => $coupon->currentPage(), 'listing' => $var];
    }

    public function transformShareList($coupon) {
        $var = [];
        $var = $coupon->map(function ($item) {
            return [
                'coupon_id' => $item->coupon_id ?? '',
                'coupon_category_name' => $item->categoryDetail->category_name ?? '',
                'coupon_original_price' => $item->coupon_original_price ?? 0,
                'coupon_total_discount' => $item->coupon_total_discount ?? 0,
                'coupon_name' => $item->coupon_name ?? '',
                'vendor_name' => $item->vendorDetail->vendor_name ?? '',
                'vendor_address' => $item->vendorDetail->vendor_street_address ?? '',
                'coupon_detail' => $item->coupon_detail ?? '',
                'remaining_coupons' => $item->remaining_coupons ?? '',
                'coupon_code' => $item->coupon_code ?? '',
                'coupon_end_date' => $item->coupon_end_date ?? '',
                'coupon_likes' => $item->total_likes ?? '',
                'vendor_ratings' => $item->vendor_ratings ?? '',
                'is_liked' => $item->is_liked ?? '',
                'coupon_comments' => $item->total_comments ?? '',
                'distance' => number_format($item->distance, 1) ?? '',
                'vendor_logo' => $item->vendorDetail->vendor_logo ?? '',
                'category_logo_image' => $item->categoryDetail->category_logo_image ?? "",
                'coupon_start_date' => $item->coupon_start_date ?? '',
                'coupon_end_date' => $item->coupon_end_date ?? '',
//                'is_favorite' => (empty($item->couponFavDetail)) ? 0 : $item->couponFavDetail->is_favorite,
                'coupon_lat' => $item->coupon_lat ?? '',
                'coupon_long' => $item->coupon_long ?? '',
                'vendor_id' => $item->vendorDetail->user_id ?? '',
            ];
        });
        return ['has_page' => $coupon->hasMorePages(), 'current_page' => $coupon->currentPage(), 'listing' => $var];
    }

    public function transformListVendor($coupon) {
        $var = array();
        foreach ($coupon as $co) {
            $item = (object) $co;
            $details = array(
                'coupon_id' => $item->coupon_id ?? '',
                'coupon_category_name' => $item->categoryDetail->category_name ?? '',
                'coupon_name' => $item->coupon_name ?? '',
                'coupon_detail' => $item->coupon_detail ?? '',
                'coupon_reedem' => $item->coupon_total_redeem ?? '',
                'coupon_created' => $item->coupon_redeem_limit ?? '',
                'coupon_active' => ($item->coupon_redeem_limit - $item->coupon_total_redeem),
                'coupon_start_date' => $item->coupon_start_date ?? '',
                'coupon_end_date' => $item->coupon_end_date ?? '',
                'coupon_logo' => $item->coupon_logo ?? "",
                'coupon_lat' => $item->coupon_lat ?? '',
                'coupon_long' => $item->coupon_long ?? '',
//                'vendor_id' => $item->vendorDetail->user_id ?? '',
            );
            array_push($var, $details);
        }
        return ['listing' => $var];
    }

}
