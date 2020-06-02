<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportFoodTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:foodtables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import food database from .sql file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::unprepared(file_get_contents('database/migrations/food_tables/04-cereals.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/05-legumes.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/06-oleaginous.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/07-vegetables.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/08-roots.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/09-fruits.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/10-meat.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/12-marine.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/14-dairy.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/15-eggs.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/16-fats.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/17-sweets.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/18-processed.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/19-beverages.sql'));
        DB::unprepared(file_get_contents('database/migrations/food_tables/20-others.sql'));
    }
}
