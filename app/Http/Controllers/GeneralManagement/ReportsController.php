<?php

namespace App\Http\Controllers\GeneralManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\SuperMarket;
use App\Models\OrderDetail;
use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;
class ReportsController extends Controller
{
    public function users()
    {
        $totalCustomers = User::where('Role_id', 3)->count();
        $totalSupermarkets = User::where('Role_id', 2)->count();
        $users = User::all();

        return view('general-management.reports.users', compact('totalCustomers', 'totalSupermarkets', 'users'));
    }

    // تقرير الطلبات لكل سوبرماركت
    public function orders()
    {
        $ordersBySupermarket = SuperMarket::withCount('orders')->get();
        return view('general-management.reports.orders', compact('ordersBySupermarket'));
    }

    // المنتجات الأكثر مبيعًا
    public function topProducts()
    {
// نجمع عدد المرات التي بيع فيها كل منتج (نجمع كمية الـ orderDetails)
        $top = OrderDetail::select('product_id', DB::raw('SUM(quantity) as orders_count'))
            ->groupBy('product_id')
            ->orderByDesc('orders_count')
            ->with(['product.supermarket'])
            ->take(10)
            ->get();

        // نبني مجموعة مهيكلة لتسهيل الاستخدام في الـ View
        $topProducts = $top->map(function($od) {
            return (object) [
                'id'           => $od->product->id,
                'ProductName'  => $od->product->name,
                'orders_count' => $od->orders_count,
                'supermarket'  => $od->product->supermarket, // يفترض علاقة belongsTo
            ];
        });

         return view('general-management.reports.top_products', compact('topProducts'));
    }
    

    // المنتجات الأعلى تقييما
    public function topRatedProducts()
    {     $topRaw = ProductReview::select(
                'product_id',
                DB::raw('AVG(rating) as avg_rating'),
                DB::raw('COUNT(*) as reviews_count')
            )
            ->groupBy('product_id')
            ->orderByDesc('avg_rating')
            ->orderByDesc('reviews_count')
            ->with(['product.supermarket'])
            ->take(10)
            ->get();

        // نهيكل البيانات لتكون جاهزة للعرض
        $topRated = $topRaw->map(function($item) {
            return (object) [
                'id'            => $item->product->id,
                'product_name'   => $item->product->product_name,
                'avg_rating'    => round($item->avg_rating, 2),
                'reviews_count' => $item->reviews_count,
                'supermarket'   => $item->product->supermarket,
            ];
        });
        return view('general-management.reports.top_rated_products', compact('topRated'));
    }
}
