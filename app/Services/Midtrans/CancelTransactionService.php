<?php
 
namespace App\Services\Midtrans;
 
use Midtrans\Transaction;
 
class CancelTransactionService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
        $this->order = json_decode($order);
    }
 
    public function cancel()
    { 
        $cancel = Transaction::cancel($this->order->uuid);
        return $cancel;
    }
}