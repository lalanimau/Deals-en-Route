<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use URL;
use Auth;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use App\Http\Services\CouponTrait;
use App\Http\Services\NotificationTrait;
use Notification;
use App\Notifications\FcmNotification;

class Coupon extends Model {

    use CouponTrait;
    use NotificationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = 'coupon';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'coupon_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'coupon_id', 'coupon_category_id', 'coupon_name', 'coupon_detail', 'coupon_logo',
        'coupon_start_date', 'coupon_end_date', 'coupon_redemption_code',
        'coupon_qrcode', 'coupon_code', 'coupon_lat', 'coupon_long', 'coupon_radius',
        'coupon_total_redeem', 'coupon_redeem_limit', 'is_active', 'is_delete', 'distance',
        'created_at', 'updated_at', 'created_by', 'coupon_radius',
        'coupon_notification_point', 'coupon_notification_sqfeet',
        'coupon_original_price', 'coupon_total_discount', 'coupon_discounted_price',
        'coupon_discounted_price', 'coupon_discounted_percent'
    ];

    public function scopeActive($query) {
        return $query->where('is_active', self::IS_TRUE);
    }

    public function scopeDeleted($query) {
        return $query->where('is_delete', self::IS_FALSE);
    }

    public function getCouponLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_logo/' . $value))) ? URL::to('/storage/app/public/coupon_logo') . '/' . $value : "";
    }
    

//     public function getCouponEndDateAttribute($value) {
//        return (!empty($value)? Carbon::parse($value)->format(\Config::get('constants.DATE_FORMAT')):'');
//    }

    public function getCouponQrcodeImageAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/qr_code_image/' . $value))) ? URL::to('/storage/app/public/qr_code_image') . '/' . $value : "";
    }

    public function getCouponOfferLogoAttribute($value) {
        return (!empty($value) && (file_exists(public_path() . '/../' . \Config::get('constants.IMAGE_PATH') . '/coupon_offer_logo/' . $value))) ? URL::to('/storage/app/public/coupon_offer_logo') . '/' . $value : "";
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function vendorDetail() {
        return $this->hasOne('App\VendorDetail', 'user_id', 'created_by');
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function categoryDetail() {
        return $this->hasOne('App\CouponCategory', 'category_id', 'coupon_category_id');
    }

    /**
     * Get the vendor detail record associated with the user.
     */
    public function couponFavDetail() {
        return $this->hasOne('App\CouponFavourite', 'coupon_id', 'coupon_id')->where('coupon_favourite.user_id', Auth::id());
    }

    public static function getNearestCoupon($data) {

        $user = Auth()->user()->userDetail;
        $circle_radius = \Config::get('constants.EARTH_RADIUS');

        $lat = $user->latitude;
        $lng = $user->longitude;
        $id = $user->category_id;
        $idsArr = explode(',', $id);
        $query = Coupon::active()->deleted()
                ->select(DB::raw('coupon.coupon_id,coupon_radius,coupon_start_date,coupon_end_date,coupon_detail,'
                                . 'coupon_name,coupon_logo,created_by,coupon_lat,coupon_original_price,coupon_total_discount,'
                                . 'coupon_long,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat)))) ) as distance'))
                ->where(\DB::raw('TIMESTAMP(`coupon_start_date`)'), '<=', date('Y-m-d H:i:s'))
                ->where(\DB::raw('TIMESTAMP(`coupon_end_date`)'), '>=', date('Y-m-d H:i:s'))
                ->whereColumn('coupon_total_redeem', '<', 'coupon_redeem_limit')
                ->havingRaw('coupon_radius >= distance');
        if (isset($data['category_id'])) {
            $query->where('coupon_category_id', $data['category_id']);
        } else if (isset($data['search'])) {
            $keyword = $data['search'];
            $query->whereIn('coupon_category_id', $idsArr);
            $query->where(function($q) use ($idsArr, $keyword) {
                $q->where(DB::raw("CONCAT(coupon_name,' ',coupon_detail)"), "LIKE", "%$keyword%")
                        ->orWhere(DB::raw("CONCAT(coupon_name,'',coupon_detail)"), "LIKE", "%$keyword%")
                        ->orWhere("coupon_name", "LIKE", "%$keyword%")
                        ->orWhere("coupon_detail", "LIKE", "%$keyword%");
            });
        } else {
            $query->whereIn('coupon_category_id', $idsArr);
        }

        $result = $query->groupBy('coupon_id')->orderBy('distance','asc')->orderBy('coupon_id','desc')->simplePaginate(\Config::get('constants.PAGINATE'));

        return $result;
    }

    public static function getCouponDetail($data) {


        $query = Coupon::active()->deleted()
                ->where('coupon_id', $data['coupon_id'])
                ->first();

        return $query;
    }

    public static function getCouponDetailByCode($data) {

        $query = Coupon::active()->deleted()
                ->where('coupon_code', $data['coupon_code'])
                ->where('created_by', Auth::id())
                ->first();

        return $query;
    }

    public static function couponList() {
        $coupon_list = Coupon::where('created_by', Auth::id())
                ->where(\DB::raw('coupon_redeem_limit'), '>', \DB::raw('coupon_total_redeem'))
                ->where(\DB::raw('TIMESTAMP(`coupon_end_date`)'), '>=', date('Y-m-d H:i:s'))
                ->active()
                ->deleted()
                ->orderBy('coupon_id', 'desc')
                ->get();
        return $coupon_list;
    }

    //save coupon
    public static function addCoupon($data) {

        $coupon = new Coupon();
        $coupon->fill($data);
        $coupon->created_by = Auth::id();
        // start date
        $startdate = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $coupon->coupon_start_date = $startdate;

        $coupon->coupon_category_id = User::find(Auth::id())->vendorDetail->vendor_category;
        $coupon->coupon_lat = User::find(Auth::id())->vendorDetail->vendor_lat;
        $coupon->coupon_long = User::find(Auth::id())->vendorDetail->vendor_long;
        // end date
        $explode = explode('-', $data['coupon_end_date']);
        $enddate = \Carbon\Carbon::parse($explode[0] . " " . $explode[1])->toDateTimeString();
        $coupon->coupon_end_date = $coupon->convertDateInUtc($enddate);
        // $coupon->coupon_qrcode_image = self::generateQrImage($coupon->coupon_code);
        if ($coupon->save()) {
            self::getNotificationUsers($coupon);
        
            return $coupon;
        }
        return false;
    }

    public static function getNotificationUsers($coupon){
        $device=[];
        $user=User::active()->deleted()
                  ->join('device_detail','device_detail.user_id','users.id')
                  ->join('user_detail','user_detail.user_id','users.id')
                  ->where('role', 'user')
                  ->where('user_detail.latitude', '!=','')
                  ->where('user_detail.longitude', '!=','')
                  ->where('device_token','!=','')
                  ->get();
       
        $circle_radius = \Config::get('constants.EARTH_RADIUS');
       
        foreach($user as $users){

        $lat = $users->latitude;
        $lng = $users->longitude;
        $id = $users->category_id;
          $idsArr = explode(',', $id);
         $query = Coupon::active()->deleted()
                ->select(DB::raw('coupon.coupon_id,coupon_radius,coupon_detail,'
                                . 'created_by,coupon_lat,'
                                . 'coupon_long,coupon_category_id,((' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(coupon_lat)) * cos(radians(coupon_long) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) * sin(radians(coupon_lat)))) ) as distance'))
                ->where('coupon_id', '=',$coupon->coupon_id)
                ->whereIn('coupon_category_id', $idsArr)
                ->havingRaw('coupon_radius >= distance')
                ->get()
                 ->toArray();
       
         if(!empty($query)) {
            $device[]= $users;
         }
        }
        
        self::sendNotification($device,$coupon);
    }


    
    
    public static function sendNotification($device,$coupon){
        
            Notification::send($device, new FcmNotification([
                'type' => 'newcoupon',
                'notification_message' => 'You have new coupon in your area.',
                'message' => 'You have new coupon in your area.',
                'coupon_id' => $coupon->coupon_id
            ]));
    }
    public static function updateCoupon($data, $id) {

        $coupon = Coupon::where('coupon_id', $id)->first();
        $coupon->fill($data);
        if (isset($data['coupon_end_date'])) {
            $explode = explode('-', $data['coupon_end_date']);

            $enddate = \Carbon\Carbon::parse($explode[0] . " " . $explode[1])->toDateTimeString();
            $coupon->coupon_end_date = $coupon->convertDateInUtc($enddate);
        }
//        if (isset($data['coupon_code'])) {
//            $coupon->coupon_qrcode_image = self::generateQrImage($coupon->coupon_code);
//        }
        if ($coupon->save()) {
            return true;
        }
        return false;
    }

    public static function generateQrImage($code) {

        $qrCode = new QrCode($code);
        $qrCode->setSize(300)
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
        header('Content-Type: ' . $qrCode->getContentType());
        $qrcodename = time() . '.png';
        $qrCode->writeFile(storage_path() . '/app/public/qr_code_image/' . $qrcodename);
        return $qrcodename;
    }

    public static function getCouponAllList() {
        $coupon_list = Coupon::where(\DB::raw('coupon_redeem_limit'), '>', \DB::raw('coupon_total_redeem'))
                ->where(\DB::raw('TIMESTAMP(`coupon_end_date`)'), '>=', date('Y-m-d H:i:s'))
                ->active()
                ->deleted()
                ->orderBy('coupon_id', 'desc')
                ->get();
        return $coupon_list;
    }

    public static function getReedemCouponMonthly($year = '') {
        $user_id = Auth::id();
        $coupons = Coupon::select(DB::raw("COALESCE(SUM(case when  month(coupon_redeem.created_at)=1 then (coupon_redeem.is_redeem) else 0 end),0) jan,
COALESCE(SUM(case when month(coupon_redeem.created_at)=2 then (coupon_redeem.is_redeem) else 0 end),0) feb,
COALESCE(SUM(case when month(coupon_redeem.created_at)=3 then (coupon_redeem.is_redeem) else 0 end),0) mar,
COALESCE(SUM(case when month(coupon_redeem.created_at)=4 then (coupon_redeem.is_redeem) else 0 end),0) april,
COALESCE(SUM(case when month(coupon_redeem.created_at)=5 then (coupon_redeem.is_redeem) else 0 end),0) may,
COALESCE(SUM(case when month(coupon_redeem.created_at)=6 then (coupon_redeem.is_redeem) else 0 end),0) june,
COALESCE(SUM(case when month(coupon_redeem.created_at)=7 then (coupon_redeem.is_redeem) else 0 end),0) july,
COALESCE(SUM(case when month(coupon_redeem.created_at)=8 then (coupon_redeem.is_redeem) else 0 end),0) aug,
COALESCE(SUM(case when month(coupon_redeem.created_at)=9 then (coupon_redeem.is_redeem) else 0 end),0) sep,
COALESCE(SUM(case when month(coupon_redeem.created_at)=10 then (coupon_redeem.is_redeem) else 0 end),0) oct,
COALESCE(SUM(case when month(coupon_redeem.created_at)=11 then (coupon_redeem.is_redeem) else 0 end),0) nov,
COALESCE(SUM(case when month(coupon_redeem.created_at)=12 then (coupon_redeem.is_redeem) else 0 end),0) dece"))
                ->leftjoin('coupon_redeem', 'coupon.coupon_id', 'coupon_redeem.coupon_id')
                ->where('created_by', $user_id)
                ->where(DB::raw('YEAR(coupon_redeem.created_at)'), '=', $year)
                ->first();

        return $coupons;
    }

    public static function getTotalCouponMonthly() {
        $user_id = Auth::id();
        $coupons = Coupon::select(DB::raw("COALESCE(SUM(case when month(created_at)=1 then coupon_redeem_limit else 0 end),0) jan,
COALESCE(SUM(case when month(created_at)=2 then coupon_redeem_limit else 0  end),0) feb,
COALESCE(SUM(case when month(created_at)=3 then coupon_redeem_limit else 0 end),0) mar,
COALESCE(SUM(case when month(created_at)=4 then coupon_redeem_limit else 0 end),0) april,
COALESCE(SUM(case when month(created_at)=5 then coupon_redeem_limit else 0 end),0) may,
COALESCE(SUM(case when month(created_at)=6 then coupon_redeem_limit else 0 end),0) june,
COALESCE(SUM(case when month(created_at)=7 then coupon_redeem_limit else 0 end),0) july,
COALESCE(SUM(case when month(created_at)=8 then coupon_redeem_limit else 0 end),0) aug,
COALESCE(SUM(case when month(created_at)=9 then coupon_redeem_limit else 0 end),0) sep,
COALESCE(SUM(case when month(created_at)=10 then coupon_redeem_limit else 0 end),0) oct,
COALESCE(SUM(case when month(created_at)=11 then coupon_redeem_limit else 0 end),0) nov,
COALESCE(SUM(case when month(created_at)=12 then coupon_redeem_limit else 0 end),0) dece"))
                ->where('created_by', $user_id)
                ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
                ->first();
        return $coupons;
    }

    public static function getTotalActiveCouponMonthly() {
        $user_id = Auth::id();
        $coupons = Coupon::select(DB::raw("COALESCE(SUM(case when month(created_at)=1 then coupon_total_redeem else 0 end),0) jan,
COALESCE(SUM(case when month(created_at)=2 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) feb,
COALESCE(SUM(case when month(created_at)=3 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) mar,
COALESCE(SUM(case when month(created_at)=4 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) april,
COALESCE(SUM(case when month(created_at)=5 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) may,
COALESCE(SUM(case when month(created_at)=6 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) june,
COALESCE(SUM(case when month(created_at)=7 then coupon_redeem_limit-coupon_total_redeem else 0  end),0) july,
COALESCE(SUM(case when month(created_at)=8 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) aug,
COALESCE(SUM(case when month(created_at)=9 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) sep,
COALESCE(SUM(case when month(created_at)=10 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) oct,
COALESCE(SUM(case when month(created_at)=11 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) nov,
COALESCE(SUM(case when month(created_at)=12 then coupon_redeem_limit-coupon_total_redeem else 0 end),0) dece"))
                ->where('created_by', $user_id)
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
                ->first();
        return $coupons;
    }

    public static function getReedemCouponWeekly($year = '', $month = '') {

        $user_id = Auth::id();
        $coupons = Coupon::select(DB::raw("COALESCE(SUM(case when  (week(coupon_redeem.created_at)-week(DATE_FORMAT(coupon_redeem.created_at ,'%Y-%m-01')))+1=1 then (coupon_redeem.is_redeem) else 0 end),0) week1,
COALESCE(SUM(case when   (week(coupon_redeem.created_at)-week(DATE_FORMAT(coupon_redeem.created_at ,'%Y-%m-01')))+1=2 then (coupon_redeem.is_redeem) else 0 end),0) week2,
COALESCE(SUM(case when   (week(coupon_redeem.created_at)-week(DATE_FORMAT(coupon_redeem.created_at ,'%Y-%m-01')))+1=3 then (coupon_redeem.is_redeem) else 0 end),0) week3,
COALESCE(SUM(case when   (week(coupon_redeem.created_at)-week(DATE_FORMAT(coupon_redeem.created_at ,'%Y-%m-01')))+1=4 then (coupon_redeem.is_redeem) else 0 end),0) week4,
COALESCE(SUM(case when   (week(coupon_redeem.created_at)-week(DATE_FORMAT(coupon_redeem.created_at ,'%Y-%m-01')))+1=5 then (coupon_redeem.is_redeem) else 0 end),0) week5,
COALESCE(SUM(case when   (week(coupon_redeem.created_at)-week(DATE_FORMAT(coupon_redeem.created_at ,'%Y-%m-01')))+1=6 then (coupon_redeem.is_redeem) else 0 end),0) week6"))
                ->leftjoin('coupon_redeem', 'coupon.coupon_id', 'coupon_redeem.coupon_id')
                ->where('created_by', $user_id)
                ->where(DB::raw('YEAR(coupon_redeem.created_at)'), '=', $year)
                ->where(DB::raw('MONTH(coupon_redeem.created_at)'), '=', $month)
                ->first();
        return $coupons;
    }

}
