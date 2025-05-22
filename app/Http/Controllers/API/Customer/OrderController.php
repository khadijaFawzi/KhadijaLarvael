<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Supermarket;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    // إنشاء طلب جديد
    public function createOrder(Request $request)
{
    $validated = $request->validate([
        'supermarket_id' => 'required|exists:super_markets,id',
        'total' => 'required|numeric',
        'delivery_fee' => 'required|numeric',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric',
    ]);

    $user_id = Auth::id();

    $order = Order::create([
        'user_id' => $user_id,
        'supermarket_id' => $request->supermarket_id,
        'status' => 'pending',
        'total' => $request->total,
        'delivery_fee' => $request->delivery_fee,
        'payment_status' => 'unpaid',
        'delivery_status' => 'pending'
    ]);

    foreach ($request->products as $prod) {
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $prod['product_id'],
            'quantity' => $prod['quantity'],
            'price' => $prod['price'],
        ]);
    }

    return response()->json([
        'status' => true,
        'order' => $order,
    ]);
}


    // رفع سند الإيداع
    public function uploadDepositReceipt(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if ($order->user_id != Auth::id()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'deposit_receipt' => 'required|file|mimes:jpeg,png,pdf|max:5120'
        ]);

        $path = $request->file('deposit_receipt')->store('deposit_receipts', 'public');
        $order->update([
            'deposit_receipt' => $path,
            'payment_status' => 'deposit_uploaded'
        ]);

        return response()->json(['status' => true, 'message' => 'Deposit uploaded']);
    }

    // طلبات المستخدم
    public function getUserOrders()
    {
        $orders = Order::with('orderDetails.product', 'supermarket')
            ->where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return response()->json(['status' => true, 'orders' => $orders]);
    }

    // تفاصيل الطلب
    public function getOrderDetails($orderId)
    {
        $order = Order::with('orderDetails.product', 'supermarket')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json(['status' => true, 'order' => $order]);
    }

    // تحديث حالة الدفع بواسطة موظف السوبرماركت
    public function updatePaymentStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        // تحقق إذا كان المستخدم موظف في السوبرماركت أو مدير
        // هنا تحقق الصلاحيات حسب نظامك

        $request->validate([
            'payment_status' => 'required|in:paid,rejected'
        ]);

        $order->update([
            'payment_status' => $request->payment_status
        ]);

        return response()->json(['status' => true, 'message' => 'Payment status updated']);
    }

    public function cancelOrder($orderId)
{
    $order = Order::findOrFail($orderId);
    $order->update(['status' => 'cancelled']);
    return response()->json(['status' => true, 'message' => 'Order cancelled']);
}

}