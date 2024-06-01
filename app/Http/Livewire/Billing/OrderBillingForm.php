<?php

namespace App\Http\Livewire\Billing;

use Exception;
use App\Models\Billing;
use App\Models\FoodOrder;
use Livewire\Component;
use App\Models\ModeOfPayment;
use App\Models\PaidAmount;
use Illuminate\Support\Facades\DB;

class OrderBillingForm extends Component
{
    public $orderBillingId, $total_amt, $payable_amt, $paid_amt, $payment_id, $paid_amounts, $billingStatus, $billingId;
    public $message = '';
    public $action = '';
    public $errorMessage = '';

    protected $listeners = [
        'orderBillingId',
        'resetInputFields'
    ];

    public function paymentProof($orderBillingId)
    {
        $this->orderBillingId = $orderBillingId;
        $this->emit('paymentId', $this->orderBillingId);

        return view('livewire.billing.payment-proof');
    }

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
        $this->errorMessage = '';
    }

    public function orderBillingId($orderBillingId)
    {
        $this->orderBillingId = $orderBillingId;
        $billing = Billing::whereId($orderBillingId)->first();
        $this->payable_amt = $billing->payable_amt;
        $this->payment_id = $billing->payment_id;
        $this->paid_amt = 0;

        $this->paid_amounts = PaidAmount::where('billing_id', $billing->id)->get();
        $this->billingStatus = $billing->status_id;
        $this->billingId = $billing->id;
    }

    public function store()
    {
        try {
            DB::beginTransaction();

            $this->validate([
                'paid_amt' => 'nullable|numeric|min:1',
                'payment_id' => 'nullable',
            ]);

            $billing = Billing::find($this->orderBillingId);
            $order = FoodOrder::whereId($this->orderBillingId);
            $latestPaidAmount = PaidAmount::where('billing_id', $this->orderBillingId)
                ->latest('created_at')
                ->first();

            $currentPayableAmt = $latestPaidAmount ? $latestPaidAmount->payable_amt : $billing->payable_amt;

            if ($this->paid_amt > $currentPayableAmt) {
                throw new Exception("The amount to pay exceeds the latest payable amount.");
            }

            $newPayableAmt = $latestPaidAmount
                ? ($latestPaidAmount->payable_amt - $this->paid_amt)
                : (0 - $this->paid_amt);

            if ($this->orderBillingId) {
                $billing->update([
                    'payment_id' => $this->payment_id,
                ]);

                $payAmount = PaidAmount::create([
                    'billing_id' => $billing->id,
                    'payable_amt' => max(0, $newPayableAmt),
                    'paid_amt' => $this->paid_amt,
                ]);

                if ($payAmount->payable_amt === 0) {
                    $billing->update(['status_id' => 5]);
                    $order->update(['status_id' => 11]);
                } elseif ($latestPaidAmount->paid_amt !== 0) {
                    $billing->update(['status_id' => 13]);
                }

                $action = 'edit';
                $message = 'Successfully Updated';
            }

            DB::commit();

            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeOrderBillingModal');
            $this->emit('refreshOrderBillingList');
            $this->emit('refreshParentOrderBilling');
        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $payments = ModeOfPayment::all();

        return view('livewire.billing.order-billing-form', compact('payments'));
    }
}
