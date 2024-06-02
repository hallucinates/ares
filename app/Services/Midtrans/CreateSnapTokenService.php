<?php
 
namespace App\Services\Midtrans;
 
use Midtrans\Snap;
 
class CreateSnapTokenService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
        $this->order = json_decode($order);
    }
 
    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $this->order->uuid,
                'gross_amount' => $this->order->total,
            ],
            'item_details' => [
                [
                    'id'       => 1,
                    'price'    => $this->order->total,
                    'quantity' => 1,
                    'name'     => $this->order->name,
                ],
            ],
            'customer_details' => [
                // 'first_name' => 'Nama',
                'email' => $this->order->email,
                // 'phone' => '081234567890',
            ]
        ];
 
        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}