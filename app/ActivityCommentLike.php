<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FcmNotification;
use Illuminate\Notifications\Notifiable;
use App\Http\Services\ActivityTrait;
use Notification;

class ActivityCommentLike extends Model {

    public $table = 'activity_comment_likes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'id';
    protected $fillable = [
        'id', 'comment_id', 'created_at', 'updated_at', 'is_like', 'liked_by'
    ];

     public function comment() {
        return $this->hasOne('App\Comment', 'comment_id', 'comment_id');
    }
    public static function addCommentLike($data) {
        $addlike = ActivityCommentLike::updateOrCreate(
                        [
                    'liked_by' => auth()->id(),
                    'comment_id' => $data['comment_id']
                        ], [
                    'is_like' => (int) $data['is_like'],
                    'liked_by' => auth()->id(),
                    'comment_id' => $data['comment_id']
                        ]
        );
        if ($addlike &&  $addlike->is_like==1 &&  $addlike->comment->created_by != Auth::id() ) {
            self::sendLikeNotification($addlike, 'activitycommentlike', \Config::get('constants.COMMENT_LIKE'));
        }
        return $addlike;
    }
    
    
    public static function sendLikeNotification($data,$type,$message){
        
         User::find($data->liked_by);
        $creatoruser = $data->comment->created_by;
        $usercreatorsend=User::find($creatoruser); 
        $fMessage = self::finalActivityMessage(Auth::id(), $message);

        // send notification success for activity like 
        Notification::send($usercreatorsend, new FcmNotification([
            'type' => $type,
            'notification_message' => $message,
            'message' => $fMessage,
            'comment_id' => $data['comment_id'] ?? '',
             'activity_id'=> $data->comment->activity_id ??'',   
        ]));
    
    }
    
    public static function finalActivityMessage($from_id,$message) {

        $userfrom = User::find($from_id);

        $fromid = (!empty($userfrom) ? $userfrom->userDetail->first_name . " " . $userfrom->userDetail->last_name : '');
        $find = ['{{from_id}}'];
        $replace = [$fromid];
        $message = str_replace($find, $replace, $message);
        return $message;
    }

}
