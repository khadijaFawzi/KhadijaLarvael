<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\supermarket_bank_accounts;
class SupermarketBankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($supermarket_id)
    {
        return view('admin.bank_account.create', compact('supermarket_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'supermarket_id' => 'required|exists:super_markets,id',
        'bank_name' => 'required',
        'account_number' => 'required',
        'iban' => 'nullable',
        'account_holder_name' => 'nullable',
    ]);
    supermarket_bank_accounts::create($validated);

    return redirect()->back()->with('success', 'تمت إضافة الحساب البنكي بنجاح');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $account = supermarket_bank_accounts::findOrFail($id);
        return view('admin.bank_account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $account = supermarket_bank_accounts::findOrFail($id);
    $validated = $request->validate([
        'bank_name' => 'required',
        'account_number' => 'required',
        'iban' => 'nullable',
        'account_holder_name' => 'nullable',
    ]);
    $account->update($validated);

    return redirect()->route('admin.supermarket.edit', $account->supermarket_id)->with('success', 'تم تعديل الحساب البنكي بنجاح');
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $account = supermarket_bank_accounts::findOrFail($id);
    $supermarket_id = $account->supermarket_id;
    $account->delete();
    // أعد التوجيه إلى صفحة تعديل بروفايل السوبرماركت
    return redirect()->route('admin.supermarket.edit', $supermarket_id)->with('success', 'تم حذف الحساب البنكي');
}


public function editBankAccount($supermarket_id, $account_id)
{
    $user = auth()->user();
    $superMarket = $user->supermarket;
    $editAccount = supermarket_bank_accounts::findOrFail($account_id);
    return view('admin.profile', compact('user', 'superMarket', 'editAccount'));
}

}
