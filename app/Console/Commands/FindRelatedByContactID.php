<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZohoCrmSDK\Api\ZohoCrmApi;

class FindRelatedByContactID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:related-accounts-by-contact-id {contactID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search related accounts by contact ID';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $relatedList = $this->getContactInfo($this->argument('contactID'))['binded_user_id'];
        if (count($relatedList) > 0) {
            echo "Related contact found. ID: ", $relatedList["id"];

            return Command::SUCCESS;
        }
        echo "This Contact is not connected with any account";

        return Command::FAILURE;
    }

    public function getContactInfo(int $contactID = 0)
    {
        return ZohoCrmApi::getInstance()
            ->setModule('Contacts')
            ->records()
            ->getRecordById($contactID)
            ->request();
    }
}
