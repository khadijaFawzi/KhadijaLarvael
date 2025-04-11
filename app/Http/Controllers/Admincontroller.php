<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\SuperMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class Admincontroller extends Controller
{
   
    public function view_order(){
      
        return view('admin.view_order');
    }
    public function orders(){
      
        return view('admin.orders');
    }
  
    public function about_us(){
      
        return view('LandPage.about_us');
    }
    public function terms(){
        return view('LandPage.Terms');
    
    }
    public function members(){
        $supermarkets = SuperMarket::all();
        return view('LandPage.members', compact('supermarkets'));
    
    }
   

      

}

