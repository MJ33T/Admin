<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ViewController extends Controller
{
    function admin(){
        if(session()->has('user')){
            return redirect('dashboard');
        }
        else{
            return view('login');
        }
    }
    
    function dashboard(){
        if(session()->has('user')){
            return view('dashboard');
        }else{
            return redirect('/admin');
        }
    }
    
    function floor(){
        if(session()->has('user')){
            return view('floor');
        }else{
            return redirect('/admin');
        }
    }

    function category(){
        if(session()->has('user')){
            return view('category');
        }else{
            return redirect('/admin');
        } 
    }

    function product(){
        if(session()->has('user')){
            return view('product');
        }else{
            return redirect('/admin');
        }
    }

    function brand(){
        if(session()->has('user')){
            return view('brand');
        }else{
            return redirect('/admin');
        }
    }

    function sub_brand(){
        if(session()->has('user')){
            return view('subBrand');
        }else{
            return redirect('/admin');
        }
    }

    function sub_brand_detail(){
        if(session()->has('user')){
            return view('subBrandDetail');
        }else{
            return redirect('/admin');
        }
    }

    function merchant(){
        if(session()->has('user')){
            return view('merchant');
        }else{
            return redirect('/admin');
        }
    }

    function mall(){
        if(session()->has('user')){
            return view('mall');
        }else{
            return redirect('/admin');
        }
    }

    function selling_indentity(){
        if(session()->has('user')){
            return view('sellingIdentity');
        }else{
            return redirect('/admin');
        }
    }

    function new_shop(){
        if(session()->has('user')){
            return view('newShop');
        }else{
            return redirect('/admin');
        }
    }

    function used_shop(){
        if(session()->has('user')){
            return view('usedShop');
        }else{
            return redirect('/admin');
        }
    }

    function other_mall(){
        if(session()->has('user')){
            return view('otherMall');
        }else{
            return redirect('/admin');
        }
    }

    function voucher(){
        if(session()->has('user')){
            return view('voucher');
        }else{
            return redirect('/admin');
        }
    }

    function promotion(){
        if(session()->has('user')){
            return view('promotion');
        }else{
            return redirect('/admin');
        }
    }

    function ads_client(){
        if(session()->has('user')){
            return view('adsClient');
        }else{
            return redirect('/admin');
        }
    }

    function create_ads(){
        if(session()->has('user')){
            return view('createAds');
        }else{
            return redirect('/admin');
        }
    }

    function ads_schedule(){
        if(session()->has('user')){
            return view('adsSchedule');
        }else{
            return redirect('/admin');
        }
    }

    function manage_admin(){
        if(session()->has('user')){
            return view('manageAdmin');
        }else{
            return redirect('/admin');
        }
    }

    function sales(){
        if(session()->has('user')){
            return view('sales');
        }else{
            return redirect('/admin');
        }
    }

    function transaction(){
        if(session()->has('user')){
            return view('transaction');
        }else{
            return redirect('/admin');
        }
    }

    function reports(){
        if(session()->has('user')){
            return view('reports');
        }else{
            return redirect('/admin');
        }
    }
}
