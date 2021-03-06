<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        switch ($this->method()) {
            case 'POST': {
                    return [
                        'vendor_name' => 'required|max:255',
                        'vendor_address' => 'required',
                        'category_name' => 'required_if:vendor_category,0|unique:coupon_category,category_name',
                        'vendor_category' => 'required',
                        'vendor_phone' => 'required',
                        'email' => 'required|email|unique:users,email|max:255',
                        'vendor_logo' => 'required|image|mimes:jpg,png,jpeg',
                        'password' => 'required|string|min:6',
                        'confirm_password' => 'required|required_with:password|same:password',
                        'vendor_city' => 'required',
                        'vendor_state' => 'required',
                        'vendor_country' => 'required',
                        'vendor_zip' => 'required|min:5|max:10',
                        'billing_home' => 'required_without:check-address|max:255',
                        'billing_city' => 'required_without:check-address|max:255',
                        'billing_state' => 'required_without:check-address|max:255',
                        'billing_zip' =>  'required_without:check-address|max:10',
                        'billing_country' => 'required_without:check-address',
                        'billing_businessname' => 'required_without:check-address|max:255',
                        'card_no' => 'required',
                        'card_holder_name' => 'required',
                        'card_expiry' => 'required',
                        'card_cvv' => 'required|regex:/^[0-9]+$/',
                        'agree' => 'required',
                    ];
                }
            case 'PATCH': {

                    return [
                        'vendor_name' => 'required|max:255',
                        'vendor_address' => 'required',
                        'vendor_category' => 'required',
                        'vendor_phone' => 'required',
                        'email' => 'required|email|unique:users,email|max:255',
                        'vendor_logo' => 'required|image|mimes:jpg,png,jpeg',
                        'password' => 'sometimes|required|string|min:6',
                        'vendor_city' => 'required',
                        'vendor_zip' => 'required|min:5|max:10',
                    ];
                }
        }
    }
    
    public function messages()
{
    return [
        'category_name.required_if' => 'The category name field is required when you have selected category option as other.',
       
    ];
}

}
