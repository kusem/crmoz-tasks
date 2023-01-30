<?php

namespace App\Http\Controllers;

use App\ModelsZoho\AccountZoho;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test(){
        $name = "Some random name";
        $data = [
            'account_name' => $name
        ];

        $name  = "Test account";
        $toCreate = [    'account_name' => $name
        ];
        $account = AccountZoho::new($toCreate);$account->saveToZoho(['workflow']);
        dump($account);

//    $newAccount =  ZohoCrmApi::getInstance()
//        ->setModule('Accounts')
//        ->records()
//        ->insertRecords([$data])
//        ->request();
        dd();



        return [
            'status'    =>  1,
            'info'  =>$newAccount
        ];
    }
}
