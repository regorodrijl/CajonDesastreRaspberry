<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
    	$sql = file_get_contents(__DIR__ . '/../../airports.sql');

        // split the statements, so DB::statement can execute them.
    	$statements = array_filter(array_map('trim', explode(';', $sql)));

    	foreach ($statements as $stmt) {
    		DB::statement($stmt);
    	}
    }
}
