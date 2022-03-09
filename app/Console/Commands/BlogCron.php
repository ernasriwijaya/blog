<?php

namespace App\Console\Commands;

use App\Models\CronJob;
use App\Models\RunningNumber;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NewTransactionNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NewTransactionNumber:cron';

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
            'cron_job_name' => 'NewTransactionNumber:cron'
        ]);

        $select_query = "SELECT a.transaction_id, a.user_id, a.transaction_number
        FROM tbl_transaction a
        JOIN (SELECT transaction_number, COUNT(*) as total
        FROM tbl_transaction 
        where transaction_status_id NOT IN (1,4)
        GROUP BY transaction_number
        HAVING total > 1 ) b
        ON a.transaction_number = b.transaction_number
        ORDER BY a.transaction_number";
    
        $transaction = DB::select($select_query);

        $result = Transaction::hydrate($transaction);

        foreach ($result as $key => $value) {

            $old_transaction_number = $value->transaction_number;
            $new_transaction_number = RunningNumber::get_running_no();
            $action_log = "Cronjob Generate New Invoice";

            $value->update([
                'transaction_number' => $new_transaction_number
            ]);

            TransactionLog::insert([
                'transaction_id' => $value->transaction_id,
                'transaction_log_action' => $action_log,
                'transaction_log_desc' => 'Generate new invoice number from #' . $old_transaction_number . ' to #' . $new_transaction_number,
                'transaction_log_created' => now(),
                'user_id' => 0
            ]);
        }

        $cronjob->update(['cron_job_finished'=>date('Y-m-d H:i:s')]);
        exit;
    }
}