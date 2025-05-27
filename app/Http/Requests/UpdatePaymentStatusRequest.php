<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // فقط مالك السوبرماركت نفسه يمكنه تعديل حالة الدفع
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
            'payment_status' => 'required|in:unpaid,deposit_uploaded,paid,rejected',
        ];
    }

    /**
     * (اختياري) تعديل رسائل الخطأ الافتراضية.
     */
    public function messages(): array
    {
        return [
            'payment_status.in' => 'حالة الدفع غير صحيحة.',
        ];
    }
}