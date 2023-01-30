<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZohoCrmSDK\Api\ZohoCrmApi;

class UpdateRelatedAccountByContactID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:related-account-by-contact-id {email} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $relatedAccount = $this->findByEmail($this->argument('email'));
        if (count($relatedAccount) > 0) {
            //dd($relatedAccount);
            echo "Contact found. ID: ", $relatedAccount[0]["id"], PHP_EOL;

            if (count($relatedAccount[0]['binded_user_id']) > 0) {
                echo "Related account found. ID: ", $relatedAccount[0]['binded_user_id']["id"], PHP_EOL;
                $changeDescription = $this->changeContactDescription(
                    $relatedAccount[0]['binded_user_id']["id"],
                    $this->argument('description')
                );
                if ($changeDescription['status'] === 1) {
                    echo 'Account description changed to ', $this->argument('description');

                    return Command::SUCCESS;
                }
                echo 'Account description not changed. Something went wrong.';

                return Command::FAILURE;
            }
            echo "This Contact is not connected with any account";

            return Command::FAILURE;
        }

        echo "No contacts with such email";

        return Command::FAILURE;
    }


    private function findByEmail(string $email = "")
    {
        return ZohoCrmApi::getInstance()
            ->setModule('Contacts')
            ->records()
            ->searchRecords()
            ->where('Email', 'equals', $email)
            ->request();
    }

    private function changeContactDescription(int $contID, string $description = ""): array
    {
        $updateAccounts = ZohoCrmApi::getInstance()
            ->setModule('Accounts')
            ->records()
            ->updateRecords(
                [
                    [
                        'id' => $contID,
                        'Description' => $description,
                    ],
                ]
            )
            ->request();

        return [
            'status' => 1,
            'data' => $updateAccounts,
        ];
    }
}
