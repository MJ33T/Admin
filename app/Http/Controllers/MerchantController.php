<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\MerchantUser;
use Session;

use Illuminate\Http\Request;

class MerchantController extends Controller
{
    function merchant_login_view(){
        return view('merchant_login');
    }

    function merchant_login(Request $req){
        $merchant_user = DB::table('merchant_users')->where(['email'=>$req->email])->first();
        if($merchant_user == null){
            return redirect('/merchant_login');
        }
        else{
            if($merchant_user->password == $req->password){
                $req->session()->put('merchant', $merchant_user);
                return redirect('/merchant_dashboard');   
            }
            else{
                return redirect('/merchant_login');
            }
        }
    }

    function merchant_dashboard(){
        if(session()->has('merchant')){
            return view('merchant_dashboard');
        }else{
            return redirect('/merchant_login');
        }
    }

    function merchant_register_view(){
        return view('merchant_register');
    }

    function merchant_register(Request $req){
        $mer = new MerchantUser;
        $mer->name = $req->name;
        $mer->ssm_no = $req->ssm_no;
        $mer->primary_contact = $req->primary_contact;
        $mer->secondary_contact = $req->secondary_contact;
        $mer->email = $req->email;
        $mer->address = $req->address;
        $mer->zip_code = $req->zip_code;
        $mer->city = $req->city;
        $mer->state = $req->state;
        $mer->country = $req->country;
        $mer->bank_name = $req->bank_name;
        $mer->bank_acc_no = $req->bank_acc_no;
        $mer->belongs_to = $req->belongs_to;
        $mer->activation = $req->activation;
        $mer->password = $req->password;
        $mer->confirm_password = $req->confirm_password;
        $resp = Http::post('https://admin.globalshopping-mall.site/api/create_merchant', [
            'merchant_name' => $req->name,
            'ssm_no' => $req->ssm_no,
            'primary_contact_no' => $req->primary_contact,
            'secondary_contact_no' => $req->secondary_contact,
            'email' => $req->email,
            'address' => $req->address,
            'zip_code' => $req->zip_code,
            'city' => $req->city,
            'state' => $req->state,
            'country' => $req->country,
            'bank_name' => $req->bank_name,
            'bank_acc_no' =>  $req->bank_acc_no,
            'belongs_to' => $req->belongs_to,
            'activation' => $req->activation,

        ]);
        if($resp->successful() == true){
            $mer->save();
            return redirect('/merchant_login');
        }
        
    }

    function merchant_logout(){
        Session::forget('merchant');
        return redirect('/merchant_login');
    }

    function merchant_add_product(){
        if(session()->has('merchant')){
            return view('merchant_add_product');
        }else{
            return redirect('/merchant_login');
        }
    }
    function merchant_brand(){
        if(session()->has('merchant')){
            return view('merchant_brand');
        }else{
            return redirect('/merchant_login');
        }
    }

    function merchant_sub_brand(){
        if(session()->has('merchant')){
            return view('merchant_sub_brand');
        }else{
            return redirect('/merchant_login');
        }
    }

    function merchant_voucher(){
        if(session()->has('merchant')){
            return view('merchant_voucher');
        }else{
            return redirect('/merchant_login');
        }
    }

    function merchant_promotion(){
        if(session()->has('merchant')){
            return view('merchant_promotion');
        }else{
            return redirect('/merchant_login');
        }
    }

    function merchant_sales(){
        if(session()->has('merchant')){
            return view('merchant_sales');
        }else{
            return redirect('/merchant_login');
        }
    }
    function merchant_product(){
        if(session()->has('merchant')){
            return view('merchant_product');
        }else{
            return redirect('/merchant_login');
        }
    }
}
