<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\CouponTrait;
use Auth;
use App\Http\Services\ActivityTrait;
use DB;

class Activity extends Model {

    use ActivityTrait;

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use CouponTrait;

    public $table = 'activity';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'activity_id';

    const IS_TRUE = 1;
    const IS_FALSE = 0;

    protected $fillable = [
        'activity_id', 'coupon_id', 'activity_name_creator', 'activity_name_friends', 'total_like',
        'total_share', 'total_comment', 'created_by','sharetext'
    ];

    /**
     * Get the coupon detail record associated with the activity.
     */
    public function coupon() {
        return $this->hasOne('App\Coupon', 'coupon_id', 'coupon_id');
    }

    public function user() {
        return $this->hasOne('App\UserDetail', 'user_id', 'created_by');
    }

    public function activitylike() {
        return $this->hasOne('App\ActivityShare', 'activity_id', 'activity_id')->where('user_id', Auth::id());
    }

    public static function addActivity($data, $userid) {

        $activity = new Activity();
        $activity->activity_name_creator = \Config::get('constants.ACTVITY_CREATOR_MESSAGE');
        $activity->activity_name_friends = \Config::get('constants.ACTVITY_FRIEND_MESSAGE');
        $activity->coupon_id = $data['coupon_id'];
        $activity->sharetext = $data['sharetext'];
        $activity->created_by = $userid;
        $activity->save();
        return $activity;
    }

    public static function activityList($id) {

        $userid = Auth::id();

        $activity = Activity::select(['activity.activity_id', 'share_friend_id','activity.sharetext', 'total_like', 'total_share', 'activity_name_friends',
                    'activity.created_by', 'total_comment', 'count_fb_friend', 'activity_name_creator', 'activity.coupon_id',
                    \DB::raw('(if(created_by != "' . $userid . '",activity_name_friends,activity_name_creator )) as activity_message')])
                ->leftJoin('coupon_share', 'coupon_share.activity_id', '=', 'activity.activity_id')
                ->havingRaw('activity_message != "" ');
        if ($id == 3) {
            $activity->where(function($q) {
                $q->where('created_by', Auth::id())
                        ->orWhere('share_friend_id', Auth::id());
            });
        } else if ($id == 0) {
            $activity->where('share_friend_id', Auth::id());
        } else if ($id == 1) {

            $activity->where('created_by', Auth::id());
        }
        $result = $activity->groupby('activity_id')
                ->orderBy('activity_id', 'desc')
                ->simplePaginate(\Config::get('constants.PAGINATE'));
        return $result;
    }

    public static function redeemActivity($data, $userid) {

        $activity = new Activity();
        $activity->activity_name_creator = '';
        $activity->activity_name_friends = \Config::get('constants.ACTVITY_FRIEND_REDEEM');
        $activity->coupon_id = $data->coupon_id;
        $activity->created_by = $userid;
        $activity->save();
        $friendlist = ($activity->getCouponShareFriend($data->coupon_id, $userid));

        $array_unique = array_map("unserialize", array_unique(array_map("serialize", $friendlist)));
        CouponShare::addRedeemCoupon($array_unique, $data->coupon_id, $activity);
        return $activity;
    }
 
    public static function getActivityDetails($data) {
        $idsArr=Activity::where('activity_id', $data['activity_id'])->first();
        $activity = Activity::select(['activity.activity_id', 'share_friend_id', 'total_like', 'total_share', 'activity_name_friends',
                            'activity.created_by', 'total_comment', 'count_fb_friend', 'activity_name_creator', 'activity.coupon_id',
                            \DB::raw('(if(activity.created_by != "' . Auth::id() . '",activity_name_friends,activity_name_creator )) as activity_message')])
                        ->leftJoin('coupon_share', 'coupon_share.activity_id', '=', 'activity.activity_id')
        
                        ->where('activity.activity_id', $data['activity_id'])
                        ->first();
        return $activity;
    }
    
     public static function getActivityDetailsById($id) {
        $activity = Activity::select(['activity.activity_id', 'share_friend_id', 'total_like', 'total_share', 'activity_name_friends',
                            'activity.created_by', 'total_comment', 'count_fb_friend', 'activity_name_creator', 'activity.coupon_id',
                            \DB::raw('(if(created_by != "' . Auth::id() . '",activity_name_friends,activity_name_creator )) as activity_message')])
                        ->leftJoin('coupon_share', 'coupon_share.activity_id', '=', 'activity.activity_id')
                        ->where('activity.activity_id', $id)
                        ->first();
        return $activity;
    }

    public static function getTagUsers($data) {

        if (isset($data['search']) && !empty($data['search'])) {
            $keyword = $data['search'];
        } else {
            $keyword = "NULL";
        }
        $query = \App\User::leftjoin('user_detail', 'user_detail.user_id', 'users.id')
                ->where('id', '!=', Auth::id())
                ->where('role', 'user');


        $query->where(function($q) use ($keyword) {
            $q->where(DB::raw("CONCAT(user_detail.first_name,' ',user_detail.last_name)"), "LIKE", "%$keyword%")
                    ->orWhere(DB::raw("CONCAT(user_detail.last_name,' ',user_detail.first_name)"), "LIKE", "%$keyword%")
                    ->orWhere("last_name", "LIKE", "%$keyword%")
                    ->orWhere("first_name", "LIKE", "%$keyword%");
        });

        $result = $query->get();

        if ($result) {
            return $result;
        }
        return false;
    }

}
