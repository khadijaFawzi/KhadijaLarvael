<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class SupermarketOrderWebController extends Controller
{
    /**
     * عرض قائمة الطلبات مع فلترة وحساب إحصائيات
     */
  public function index(Request $request, $supermarket_id)
{
    $query = Order::with('orderDetails.product','user')
        ->where('supermarket_id', $supermarket_id);

    if ($status = $request->get('status')) {
        $query->where('status', $status);
    }

    $orders = $query->orderBy('id','desc')->get();

    $newOrdersCount        = Order::where('supermarket_id', $supermarket_id)->where('status','pending')->count();
    $processingOrdersCount = Order::where('supermarket_id', $supermarket_id)->where('status','processing')->count();
    $allOrdersCount        = Order::where('supermarket_id', $supermarket_id)->count();

    return view('admin.orders.index', [
        'orders'                 => $orders,
        'newOrdersCount'         => $newOrdersCount,
        'processingOrdersCount'  => $processingOrdersCount,
        'allOrdersCount'         => $allOrdersCount,
        'supermarketId'          => $supermarket_id,
    ]);
}


    /**
     * عرض تفاصيل طلب محدّد
     */
    public function show(Request $request, $supermarket_id, $orderId)
    {
        $order = Order::with('orderDetails.product','user')
            ->where('id', $orderId)
            ->where('supermarket_id', $supermarket_id)
            ->firstOrFail();

        return view('admin.orders.show', compact('order'));
    }

    /**
     * تحديث حالة الدفع
     */
    public function updatePaymentStatus(Request $request, $supermarket_id, $orderId)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,deposit_uploaded,paid,rejected',
        ]);

        $order = Order::where('id',$orderId)
            ->where('supermarket_id',$supermarket_id)
            ->firstOrFail();

        $order->update(['payment_status'=>$request->payment_status]);

        return back()->with('success','تم تحديث حالة الدفع');
    }

    /**
     * تحديث حالة الطلب والشحن
     */
    
public function updateOrderStatus(Request $request, $supermarket_id, $orderId)
{
    $request->validate([
        'status'          => 'required|in:pending,processing,completed,cancelled',
        'delivery_status' => 'nullable|string|max:255',
        'tracking_code'   => 'nullable|string|max:100',
    ]);

    $order = Order::where('id', $orderId)
                  ->where('supermarket_id', $supermarket_id)
                  ->firstOrFail();

    $order->update([
        'status'          => $request->status,
        'delivery_status' => $request->delivery_status ?? $order->delivery_status,
        'tracking_code'   => $request->tracking_code   ?? $order->tracking_code,
    ]);

    return back()->with('success', 'تم تحديث حالة الطلب');
}

    /**
     * إحصائيات جانبية للداشبورد
     */
    public function sidebarStats($supermarket_id)
    {
        $newOrdersCount        = Order::where('supermarket_id',$supermarket_id)->where('status','pending')->count();
        $processingOrdersCount = Order::where('supermarket_id',$supermarket_id)->where('status','processing')->count();

        return view('supermarket.dashboard', compact('newOrdersCount','processingOrdersCount'));
    }
}
