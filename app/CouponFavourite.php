<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use URL;
use Carbon\Carbon;

class CouponFavourite extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'coupon_favourite';
    public $primaryKey = 'favourite_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'user_id', 'coupon_id', 'created_at', 'updated_at', 'is_favorite'
    ];

    /**
     * Get the vendor detail record associated with the user.
     */
    public static function Coupon() {
        return $this->belongsToMany('App\Coupon', 'coupon_id', 'coupon_id');
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function categoryDetail() {
        return $this->hasOne('App\CouponCategory', 'category_id', 'coupon_category_id');
    }

    //category logo image
    public function getCategoryLogoImageAttribute($value) {

        return (!empty($value)) ? URL::to('/storage/app/public/category_logo_image') . '/' . $value : "";
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function vendorDetail() {
        return $this->hasOne('App\VendorDetail', 'user_id', 'created_by');
    }

    //update or create favourtie coupon data ssss
    public static function addFavCoupon($data) {

        $addfav = CouponFavourite::updateOrCreate(['user_id' => Auth::id(),
                    'coupon_id' => $data['coupon_id']], ['user_id' => Auth::id(), 'coupon_id' => $data['coupon_id'],
                    'is_favorite' => $data['is_favourite']]
        );
        if ($addfav) {
            return true;
        }
        return false;
    }

    // coupon favorite list
    public static function getCouponFavList($data) {

        $user = Auth()->user()->userDetail;
        $lat = $user->latitude;
        $lng = $user->longitude;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $result = CouponFavourite::
                select(DB::raw('coupon.coupon_id,coupon_favourite.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,coupon_original_price,coupon_total_discount,(coupon_redeem_limit - coupon_total_redeem) as remaining_coupons,coupon_code,coupon_end_date,coupon_original_price,coupon_total_discount,'
                                . 'coupon_name,coupon_logo,coupon_lat,coupon_long,created_by,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat))))) as distance'))
                ->leftJoin('coupon', 'coupon_favourite.coupon_id', '=', 'coupon.coupon_id')
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->where('user_id', Auth::id())
                ->where('is_favorite', self::IS_TRUE)
                ->orderBy('distance')
                ->simplePaginate(\Config::get('constants.PAGINATE'));


        return $result;
    }

    // coupon favorite list limit 5
    public static function getCouponAllFavListLimit() {

        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $result = CouponFavourite::
                select(DB::raw('coupon.coupon_id,coupon_favourite.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,coupon_lat, (coupon_redeem_limit - coupon_total_redeem) AS new_bal,'
                                . 'coupon_long,created_by,coupon_category_id,user_detail.user_id,((' . $circle_radius . ' * acos(cos(radians(user_detail.latitude)) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(user_detail.longitude)) + sin(radians(user_detail.latitude)) * sin(radians(coupon_lat))))) as distance'))
                ->leftJoin('coupon', 'coupon_favourite.coupon_id', '=', 'coupon.coupon_id')
                ->leftJoin('user_detail', 'coupon_favourite.user_id', '=', 'user_detail.user_id')
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->where('is_favorite', self::IS_TRUE)
                ->havingRaw('new_bal = 5')
                ->orderBy('distance')
                ->get();

        return $result;
    }

    // coupon favorite list fav expire
    public static function getCouponAllFavExpire() {
        $date = Carbon::now()->format('Y-m-d');

        $circle_radius = \Config::get('constants.EARTH_RADIUS');
        $result = CouponFavourite::
                select(DB::raw('coupon.coupon_id,coupon_favourite.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_lat,DATE_SUB(coupon_end_date, INTERVAL 1 DAY)  as datesub,'
                                . 'coupon_long,created_by,coupon_category_id,user_detail.user_id,((' . $circle_radius . ' * acos(cos(radians(user_detail.latitude)) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(user_detail.longitude)) + sin(radians(user_detail.latitude)) * sin(radians(coupon_lat))))) as distance'))
                ->leftJoin('coupon', 'coupon_favourite.coupon_id', '=', 'coupon.coupon_id')
                ->leftJoin('user_detail', 'coupon_favourite.user_id', '=', 'user_detail.user_id')
                ->where('is_active', self::IS_TRUE)
                ->where('is_delete', self::IS_FALSE)
                ->where('is_favorite', self::IS_TRUE)
                ->having(\DB::raw('date_format(datesub,"%Y-%m-%d")'), "$date")
                ->orderBy('distance')
                ->get();

        return $result;
    }

    public static function getLikes($id) {
        $likes = CouponFavourite::select(\DB::raw('count(favourite_id) as total_likes'))
                ->where('coupon_id', $id)
                ->where('is_favorite', self::IS_TRUE)
                ->first();
        if ($likes) {
            return $likes->getAttributes();
        } else {
            return 0;
        }
    }

    public static function getUserLike($id, $user_id) {
        $likes = CouponFavourite::select(\DB::raw('*'))
                ->where('coupon_id', $id)
                ->where('user_id', $user_id)
                ->where('is_favorite', self::IS_TRUE)
                ->first();
        if (count($likes) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}
