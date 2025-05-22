<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\supermarket_bank_accounts;
class SupermarketBankAccountController extends Controller
{
   
    public function getBankAccounts($supermarketId)
    {
        $accounts = supermarket_bank_accounts::where('supermarket_id', $supermarketId)->get();

        return response()->json(['status' => true, 'accounts' => $accounts]);
    }
}
