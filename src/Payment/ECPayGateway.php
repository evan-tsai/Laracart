<?php


namespace EvanTsai\Laracart\Payment;


use Illuminate\Database\Eloquent\Model;

class ECPayGateway extends PaymentGateway
{
    protected $sdk;

    public function __construct(\ECPay_AllInOne $sdk)
    {
        parent::__construct();

        $this->sdk = $sdk;
    }

    public function checkOut(Model $order)
    {
        try {
            $this->sdk->ServiceURL  = config('laracart.gateways.ecpay.api_url');
            $this->sdk->HashKey     = config('laracart.gateways.ecpay.hash_key');
            $this->sdk->HashIV      = config('laracart.gateways.ecpay.hash_iv');
            $this->sdk->MerchantID  = config('laracart.gateways.ecpay.merchant_id');
            $this->sdk->Send['ReturnURL'] = config('laracart.callback_route');
            $this->sdk->Send['MerchantTradeNo']   = $order->id;
            $this->sdk->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
            $this->sdk->Send['TotalAmount']       = (int) 2000;
            $this->sdk->Send['TradeDesc']         = '商店訂購商品，訂單編號：' . $order->id;
            $this->sdk->Send['NeedExtraPaidInfo'] = 'Y';
            $this->sdk->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL;
            $this->sdk->Send['EncryptType'] = 1;

            array_push($this->sdk->Send['Items'], array(
                'Name'  => "商品名稱",
                'Price'  => (int)1000,
                'Currency'  => "元",
                'Quantity'  => (int) "1",
                'URL'  => ""));

            $this->sdk->CheckOut();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
