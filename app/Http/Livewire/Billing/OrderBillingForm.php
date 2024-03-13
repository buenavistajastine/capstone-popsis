<?php

namespace App\Http\Livewire\Billing;

use Exception;
use App\Models\Billing;
use Livewire\Component;
use App\Models\ModeOfPayment;
use Illuminate\Support\Facades\DB;

class OrderBillingForm extends Component
{
    public $orderBillingId, $total_amt, $payable_amt, $paid_amt, $payment_id;
    public $message = '';
    public $action = '';

    protected $listeners = [
        'orderBillingId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function orderBillingId($orderBillingId)
    {
        $this->orderBillingId = $orderBillingId;
        $billing = Billing::whereId($orderBillingId)->first();
        $this->payable_amt = $billing->payable_amt;
        $this->payment_id = $billing->payment_id;
        $this->paid_amt = 0;

    }

    public function store()
    {
        try {
            DB::beginTransaction();

            $this->validate([
                'paid_amt' => 'nullable|numeric',
                'payment_id' => 'nullable',
            ]);

            $billing = Billing::find($this->orderBillingId);
            $newPayableAmt = $billing->payable_amt - $this->paid_amt;

            if ($this->orderBillingId) {
                $billing->update([
                    'payable_amt' => max(0, $newPayableAmt),
                    'paid_amt' => $billing->paid_amt + $this->paid_amt,
                    'payment_id' => $this->payment_id,
                ]);

                if ($billing->payable_amt == 0) {
                    $billing->update(['status_id' => 5]);
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
            $errorMessage = $e->getMessage();
            $this->emit('flashAction', 'error', $errorMessage);
        }
    }

    public function render()
    {
        $payments = ModeOfPayment::all();
        
        return view('livewire.billing.order-billing-form', compact('payments'));
    }
}