<?php

namespace App\Http\Services;

use Mail;
use App\Mail\EmailVerify;
use App\Mail\SendPasswordMail;
trait MailTrait {
    
    
  public function sendMail($array_mail){

   if($array_mail['type']=='verify'){
         Mail::to($array_mail['to'])->send(new EmailVerify($array_mail['data']));
   }else if($array_mail['type']=='password'){
          Mail::to($array_mail['to'])->send(new SendPasswordMail($array_mail['data']));
   }
    
  }
  
  public function confirmCode(){
      
  }
    
}