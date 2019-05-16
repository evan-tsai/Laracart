<?php


namespace EvanTsai\Laracart\Modules\Traits;


use EvanTsai\Laracart\Gateways\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait Checkout
{
    public function checkout(Request $request)
    {
        $gateway = $this->validateAndRetrieveGateway($request);

        $this->order->payment_gateway = $gateway;
        $this->order->save();

        $gatewayClass = $this->getGatewayClass($gateway);

        return $gatewayClass->checkout($this->order);
    }

    protected function validateAndRetrieveGateway($request)
    {
        $availableGateways = config('laracart.available_gateways');

        $request->validate([
            'gateway' => [
                'sometimes',
                Rule::in($availableGateways),
            ]
        ]);

        return $request->input('gateway', $availableGateways[0]);
    }

    protected function getGatewayClass($gateway)
    {
        $gatewayClassName = config('laracart.gateways.' . $gateway . '.class');
        $gatewayClass = new $gatewayClassName;

        if (!$gatewayClass instanceof PaymentGateway) {
            throw new \UnexpectedValueException($gatewayClassName . ' is not a Payment Gateway');
        }

        return $gatewayClass;
    }
}
