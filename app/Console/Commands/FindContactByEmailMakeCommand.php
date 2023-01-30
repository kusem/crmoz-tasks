<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use ZohoCrmSDK\Api\ZohoCrmApi;

class FindContactByEmailMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:contact-by-email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search Contact by email and returns it\'s ID if found';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $record = $this->findByEmail($this->argument('email'));
            if (count($record) > 0) {
                echo "User found. ID: ", $record[0]['id'];

                return Command::SUCCESS;
            }
        } catch (\Exception $e) {
            echo "No Contacts found with such email";

            return Command::FAILURE;
        }
        echo "Unknown error";

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
}
