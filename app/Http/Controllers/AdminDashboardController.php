<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
class AdminDashboardController extends Controller
{
  public function index()
    {
        // اجمع الإحصائيات المطلوبة
        $usersCount = User::count();
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $categoriesCount = Category::count();

        $lastUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $lastOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        return view('general-management.dashboard', compact(
            'usersCount',
            'ordersCount',
            'productsCount',
            'categoriesCount',
            'lastUsers',
            'lastOrders'
        ));
    }
}
