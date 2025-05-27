<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // فقط مالك السوبرماركت نفسه يمكنه تعديل حالة الطلب
        // نفترض أن المسار يستخدم Route Model Binding ويسمّي المعامل 'order'
        $order = $this->route('order');
        return auth()->check()
            && auth()->user()->supermarket_id === $order->supermarket_id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status'          => 'required|in:pending,processing,completed,cancelled',
            'delivery_status' => 'nullable|string|max:255',
            'tracking_code'   => 'nullable|string|max:100',
        ];
    }

    /**
     * (اختياري) تعديل رسائل الخطأ الافتراضية.
     */
    public function messages(): array
    {
        return [
            'status.in' => 'الحالة يجب أن تكون إحدى القيم: pending, processing, completed, cancelled.',
        ];
    }
}
