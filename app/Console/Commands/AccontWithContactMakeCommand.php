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

        $newAccountId =  $this->createNewAccount('Іван')['data'][0];
        $newContactId =  $this->createNewContact('Дорн')['data'][0];
        $bindContact = $this->bindAccountToContact($newAccountId, $newContactId);

        return Command::SUCCESS;
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
