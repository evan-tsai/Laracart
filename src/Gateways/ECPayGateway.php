<?php


namespace EvanTsai\Laracart\Gateways;


use ECPay_AllInOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ECPayGateway extends PaymentGateway
{
    protected $sdk;

    public function __construct()
    {
        parent::__construct();

        $this->sdk = new ECPay_AllInOne;
    }

    public function getOrderIdField()
    {
        return 'MerchantTradeNo';
    }

    public function checkOut(Model $order)
    {
        try {
            $this->sdk->ServiceURL = config('laracart.gateways.ecpay.api_url');
            $this->sdk->HashKey    = config('laracart.gateways.ecpay.hash_key');
            $this->sdk->HashIV     = config('laracart.gateways.ecpay.hash_iv');
            $this->sdk->MerchantID = config('laracart.gateways.ecpay.merchant_id');

            $this->sdk->Send['ReturnURL']         = route(config('laracart.callback_route'), ['gateway' => 'ecpay']);
            $this->sdk->Send['OrderResultURL']    = route(config('laracart.callback_redirect_route'));
            $this->sdk->Send['MerchantTradeNo']   = $order->id;
            $this->sdk->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
            $this->sdk->Send['TradeDesc']         = '商店訂購商品，訂單編號：' . $order->id;
            $this->sdk->Send['NeedExtraPaidInfo'] = 'Y';
            $this->sdk->Send['ChoosePayment']     = $order->payment_method ?: \ECPay_PaymentMethod::ALL;
            $this->sdk->Send['EncryptType']       = 1;
            $this->sdk->Send['Items']             = $this->getItems($order);
            $this->sdk->Send['TotalAmount']       = (int) $this->getTotal($order);

            return ['html' => $this->sdk->CheckOutString(null)];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function callback(Model $order, Request $request)
    {
        if (!$order->payment_type) $order->payment_type = $request->PaymentType;
        $order->expire_date = $request->ExpireDate;
        $order->payment_date = $request->TradeDate;
        $order->payment_id = $request->TradeNo;
        $order->status = ($request->RtnCode === 1) ? $order::STATUS_COMPLETED : $order::STATUS_FAILED;

        $order->save();
    }

    protected function getItems($order)
    {
        return $order->products->map(function ($item) {
            return [
                'Name' => $item->name,
                'Price' => (int) $item->price,
                'Currency' => '元',
                'Quantity' => (int) $item->pivot->quantity,
            ];
        });
    }

    protected function getTotal($order)
    {
        return $order->products->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });
    }
}
