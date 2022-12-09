<?php

use App\Helpers\AppConstants;
use App\Models\ApplicationForm;
use App\Models\BusinessAccount;
use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid as RamseyUuid;

if (! function_exists('authUser')) {
    function authUser() {
        if(Auth::check()){
            return User::findOrFail(Auth::user()->id);
        }
        return null;
    }
}

if (! function_exists('app_name')) {
    function app_name() {
        return env('APP_NAME');
    }
}

if (! function_exists('app_is_dev_mode')) {
    function app_is_dev_mode() {
        return env('APP_ENV') == 'local';
    }
}

if (! function_exists('app_url')) {
    function app_url() {
        return env('APP_URL');
    }
}

if (! function_exists('active_link')) {
    function active_link($uri) {
        $active = '';
        if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}

if (! function_exists('is_deleted')) {
    function is_deleted($model){
        return empty($model->deleted_at) ? false : true;
    }
}

if (! function_exists('app_uuid_generator')) {
    function app_uuid_generator(){
        return RamseyUuid::uuid4()->toString();
    }
}

if (! function_exists('user_code_generator')) {
    function user_code_generator(){
        return uniqid();
    }
}


if (! function_exists('mercant_code_generator')) {
    function mercant_code_generator(){
        return uniqid();
    }
}

if (! function_exists('create_wallet_for')) {
    function create_wallet_for(User $user, $currency_name = AppConstants::USD, BusinessAccount $businessAccount = null){
        if ($user == null && $businessAccount == null) {
            return false;
        }else{
            $wallet = new Wallet();
            $wallet = $wallet->fill([
                'uuid' => app_uuid_generator(),
                'owner_id' => $user->id,
                'business_account_id' => $businessAccount == null ? null : $businessAccount->id,
                'currency_id' => Currency::where('short_name', $currency_name)->first()->id,
                'balance' => 0,
            ]);
            $wallet->save();
            return true;
        }
    }
}