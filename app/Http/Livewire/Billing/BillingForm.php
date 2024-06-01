<?php

namespace App\Http\Livewire\Billing;

use Exception;
use App\Models\Billing;
use App\Models\Booking;
use Livewire\Component;
use App\Models\ModeOfPayment;
use App\Models\PaidAmount;
use Illuminate\Support\Facades\DB;

class BillingForm extends Component
{
    public $billingId, $total_amt, $payable_amt, $paid_amt, $payment_id, $paid_amounts, $billingStatus;
    public $message = '';
    public $action = '';
    public $errorMessage = '';

    protected $listeners = [
        'billingId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
        $this->errorMessage = '';
    }

    public function billingId($billingId)
    {
        $this->billingId = $billingId;
        $billing = Billing::whereId($billingId)->first();
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
                'paid_amt' => 'required|numeric|min:1',
                'payment_id' => 'required',
            ]);

            $billing = Billing::find($this->billingId);

            $latestPaidAmount = PaidAmount::where('billing_id', $this->billingId)
                ->latest('created_at')
                ->first();

            $currentPayableAmt = $latestPaidAmount ? $latestPaidAmount->payable_amt : $billing->payable_amt;

            // Check if the paid amount exceeds the payable amount
            if ($this->paid_amt > $currentPayableAmt) {
                throw new Exception("The amount to pay exceeds the latest payable amount.");
            }

            $newPayableAmt = $currentPayableAmt - $this->paid_amt;

            if ($this->billingId) {
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
                    Booking::where('id', $billing->booking_id)->update(['status_id' => 11]);
                } elseif ($latestPaidAmount && $latestPaidAmount->paid_amt !== 0) {
                    $billing->update(['status_id' => 13]);
                }

                $action = 'edit';
                $message = 'Successfully Updated';
            }

            DB::commit();

            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeBillingModal');
            $this->emit('refreshBillingList');
            $this->emit('refreshParentBilling');
        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $payments = ModeOfPayment::all();

        return view('livewire.billing.billing-form', compact('payments'));
    }
}
