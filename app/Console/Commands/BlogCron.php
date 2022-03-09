<?php

namespace App\Console\Commands;

use App\Models\CronJob;
use App\Models\RunningNumber;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NewPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NewPosts:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Duplicate Transaction Number';

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
     * @return int
     */
    public function handle()
    {
        $cronjob = CronJob::create([
            'cron_job_name' => 'NewPosts:cron'
        ]);

        $select_query = "SELECT a.title, a.body, a.slug
        FROM laravel a
        JOIN (SELECT title, COUNT(*) as total
        FROM laravel 
        where id NOT IN (1,4)
        GROUP BY title
        HAVING total > 1 ) b
        ON a.title = b.title
        ORDER BY a.title";
    
        $transaction = DB::select($select_query);

        $result = Transaction::hydrate($transaction);

        foreach ($result as $key => $value) {

            $old_title = $value->title;
            $new_title = RunningNumber::get_running_no();
            $action_log = "Cronjob Generate New Posts";

            $value->update([
                'title' => $title
            ]);

            TransactionLog::insert([
                'id' => $value->id,
                'title_action' => $action_log,
                'title_desc' => 'Generate  #' . $old_title . ' to #' . $new_title,
                'title_created' => now(),
                'id' => 0
            ]);
        }

        $cronjob->update(['cron_job_finished'=>date('Y-m-d H:i:s')]);
        exit;
    }
}