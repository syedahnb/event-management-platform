<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->executeSeeder(UserSeeder::class);
        $this->executeSeeder(EventSeeder::class);
    }

    /**
     * Execute a seeder and output whether it was successful or not.
     */
    private function executeSeeder(string $seeder): void
    {
        try {
            $this->call($seeder);
            $this->command->info("Successfully executed {$seeder}.");
        } catch (\Exception $e) {
            $this->command->error("Failed to execute {$seeder}: " . $e->getMessage());
        }
    }
}
