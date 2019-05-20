<?php


namespace EvanTsai\Laracart\Gateways;


use ECPay_AllInOne;
use EvanTsai\Laracart\Models\Order;
use Illuminate\Http\Request;

class ECPayGateway implements PaymentContract
{
    const CODE_SUCCESS = '1|OK';
    const CODE_FAIL = '0|fail';

    protected $sdk;
    protected $hashKey;
    protected $hashIV;

    public function __construct()
    {
        $this->sdk = new ECPay_AllInOne;
        $this->hashKey = config('laracart.gateways.ecpay.hash_key');
        $this->hashIV = config('laracart.gateways.ecpay.hash_iv');
    }

    public function getGatewayKey()
    {
        return 'ecpay';
    }

    public function getOrderIdField()
    {
        return 'MerchantTradeNo';
    }

    public function checkOut(Order $order)
    {
        try {
            $this->sdk->ServiceURL = config('laracart.gateways.ecpay.api_url');
            $this->sdk->MerchantID = config('laracart.gateways.ecpay.merchant_id');
            $this->sdk->HashKey    = $this->hashKey;
            $this->sdk->HashIV     = $this->hashIV;

            $this->sdk->Send['ReturnURL']         = route('laracart.callback', $order->id);
            $this->sdk->Send['PaymentInfoURL']    = route('laracart.callback', $order->id);
            $this->sdk->Send['OrderResultURL']    = route(config('laracart.callback_redirect_route'));
            // TODO: Direct back to order
            $this->sdk->Send['ClientBackURL']     = url('/');
            $this->sdk->Send['MerchantTradeNo']   = $order->id;
            $this->sdk->Send['MerchantTradeDate'] = $order->created_at->format('Y/m/d H:i:s');
            $this->sdk->Send['TradeDesc']         = '商店訂購商品，訂單編號：' . $order->id;
            $this->sdk->Send['NeedExtraPaidInfo'] = 'Y';
            $this->sdk->Send['ChoosePayment']     = $order->payment_method ?: \ECPay_PaymentMethod::ALL;
            $this->sdk->Send['Items']             = $this->getItems($order);
            $this->sdk->Send['TotalAmount']       = (int) $this->getTotal($order);
            $this->sdk->Send['ExpireDate']        = 7;
            $this->sdk->Send['EncryptType']       = 1;

            return ['html' => $this->sdk->CheckOutString(null)];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function callback(Order $order, Request $request)
    {
        if (!$order->payment_method) $order->payment_method = $request->PaymentType;
        $order->payment_date = $request->TradeDate;
        $order->payment_id = $request->TradeNo;
        $order->status = $order::STATUS_FAILED;

        $code = self::CODE_FAIL;

        $check = \ECPay_CheckMacValue::generate($request->except(['gateway']), $this->hashKey, $this->hashIV, 1);

        if ($check === $request->CheckMacValue) {
            switch ($request->RtnCode) {
                case 1:
                    $code = self::CODE_SUCCESS;
                    $order->status = $order::STATUS_COMPLETED;
                    break;
                case 2:
                case 10100073:
                    $code = self::CODE_SUCCESS;
                    $order->expire_date = $request->ExpireDate;
                    $order->status = $order::STATUS_PENDING;
                    break;
            }
        }

        $order->save();

        return $code;
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
