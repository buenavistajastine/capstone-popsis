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
    public $billingId, $total_amt, $payable_amt, $paid_amt, $payment_id, $paid_amounts;
    public $message = '';
    public $action = '';

    protected $listeners = [
        'billingId',
        'resetInputFields'
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function billingId($billingId)
    {
        $this->billingId = $billingId;
        $billing = Billing::whereId($billingId)->first();
        $this->payable_amt = $billing->payable_amt;
        $this->payment_id = $billing->payment_id;
        $this->paid_amt = 0;

        $this->paid_amounts = PaidAmount::where('billing_id', $billing->id)->get();
    }

    public function store()
    {
        try {
            DB::beginTransaction();

            $this->validate([
                'paid_amt' => 'nullable|numeric',
                'payment_id' => 'nullable',
            ]);

            $billing = Billing::find($this->billingId);

            $booking = Booking::where('id', $billing->booking_id);
            $latestPaidAmount = PaidAmount::where('billing_id', $this->billingId)
                ->latest('created_at')
                ->first();

            $newPayableAmt = $latestPaidAmount
                ? ($latestPaidAmount->payable_amt - $this->paid_amt)
                : (0 - $this->paid_amt);

            if ($this->billingId) {
                $billing->update([

                    'payment_id' => $this->payment_id,
                ]);

                PaidAmount::create([
                    'billing_id' => $billing->id,
                    'payable_amt' => max(0, $newPayableAmt),
                    'paid_amt' => $this->paid_amt,
                ]);

                if ($latestPaidAmount->payable_amt == 0) {
                    $billing->update(['status_id' => 5]);
                    $booking->update(['status_id' => 11]);
                } elseif ($latestPaidAmount->paid_amt !== 0) {
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
            $errorMessage = $e->getMessage();
            $this->emit('flashAction', 'error', $errorMessage);
        }
    }

    public function render()
    {
        $payments = ModeOfPayment::all();

        return view('livewire.billing.billing-form', compact('payments'));
    }
}
