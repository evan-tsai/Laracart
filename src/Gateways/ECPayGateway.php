<?php


namespace EvanTsai\Laracart\Gateways;


use ECPay_AllInOne;
use Illuminate\Database\Eloquent\Model;

class ECPayGateway extends PaymentGateway
{
    protected $sdk;

    public function __construct()
    {
        parent::__construct();

        $this->sdk = new ECPay_AllInOne;
    }

    public function checkOut(Model $order)
    {
        try {
            $this->sdk->ServiceURL  = config('laracart.gateways.ecpay.api_url');
            $this->sdk->HashKey     = config('laracart.gateways.ecpay.hash_key');
            $this->sdk->HashIV      = config('laracart.gateways.ecpay.hash_iv');
            $this->sdk->MerchantID  = config('laracart.gateways.ecpay.merchant_id');
            $this->sdk->Send['ReturnURL'] = route(config('laracart.callback_route'));
            $this->sdk->Send['MerchantTradeNo']   = uniqid();
            $this->sdk->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
            $this->sdk->Send['TotalAmount']       = (int) 2000;
            $this->sdk->Send['TradeDesc']         = '商店訂購商品，訂單編號：' . $order->id;
            $this->sdk->Send['NeedExtraPaidInfo'] = 'Y';
            $this->sdk->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL;
            $this->sdk->Send['EncryptType'] = 1;

            $items = $order->products->map(function ($item) {
                return [
                    'Name' => $item->name,
                    'Price' => (int) $item->price,
                    'Currency' => '元',
                    'Quantity' => (int) $item->pivot->quantity,
                ];
            });

            $this->sdk->Send['Items'] = $items->toArray();

            return $this->sdk->CheckOutString(null);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
