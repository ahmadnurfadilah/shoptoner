<?php

namespace App\Console\Commands;

use App\Models\Payment\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check payment status from TON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payments = Payment::with('items')
            ->where('status', 'pending')
            ->whereNotNull('boc')
            ->get();
        foreach ($payments as $payment) {
            foreach ($payment->items as $item) {
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                ])->get("https://testnet.toncenter.com/api/v3/transactions?account={$item->payable->store->wallet_address}&limit=128&offset=0&sort=desc");

                if ($response->successful()) {
                    $trxs = $response->json('transactions');
                    foreach ($trxs as $trx) {
                        if (
                            isset($trx['in_msg']['message_content']['decoded']['comment']) &&
                            Str::after($trx['in_msg']['message_content']['decoded']['comment'], 'INVOICE:') === $payment->trx_id
                        ) {
                            $payment->setSuccess();
                        }
                    }
                }
            }
        }
    }
}
