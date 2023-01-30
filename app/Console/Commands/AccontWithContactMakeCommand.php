<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZohoCrmSDK\Api\ZohoCrmApi;

class AccontWithContactMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:AccountWithContact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new Account and bounded Contact';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $newAccount =  $this->createNewAccount('Іван');
        $newContact =  $this->createNewContact('Дорн');

        if($newAccount['status']===1 && $newContact['status']){
            $bindContact = $this->bindAccountToContact($newAccount['data'][0], $newContact['data'][0])['status'];
            echo 'New account created. ID: ' , $newAccount['data'][0] , PHP_EOL;
            echo 'New contact created. ID: ' , $newContact['data'][0] , PHP_EOL;
            if($bindContact === 1) {
                echo 'Contact binded with account';
                return Command::SUCCESS;
            }
            echo 'Contact not binded with account. Something went wrong.';
            return Command::FAILURE;
        }
        print_r('Something went wrong. Sorry.');
        return Command::FAILURE;
    }

    private function createNewAccount(string $name = 'Пан Василь' ) : array
    {
        $data = [
            'Account_Name' => $name
        ];
        $newAccount =  ZohoCrmApi::getInstance()
            ->setModule('Accounts')
            ->records()
            ->insertRecords([$data])
            ->request();
        return [
            'status'    =>  1,
            'data'      =>  $newAccount
        ];
    }

    private function createNewContact(string $name = 'Пупкін' ) : array
    {
        $data = [
            'Last_Name' => $name
        ];
        $newContact =  ZohoCrmApi::getInstance()
            ->setModule('Contacts')
            ->records()
            ->insertRecords([$data])
            ->request();
        return [
            'status'    =>  1,
            'data'      =>  $newContact
        ];
    }

private function bindAccountToContact(int $accID, int $contID) : array
    {
        $updatedContact = ZohoCrmApi::getInstance()
                ->setModule('Contacts')
                ->records()
                ->updateRecords([
                    [
                        'id' => $contID,
                        '$se_module' => 'Accounts',
                        'Account_Name' => [
                            "id" => $accID
                        ]
                    ]
                ])
                ->request();
        return [
            'status'    =>  1,
            'data'      =>  $updatedContact
        ];
    }


}
