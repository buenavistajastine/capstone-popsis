<?php

namespace App\Http\Livewire\Billing;

use App\Models\GcashPayment;
use Livewire\Component;

class PaymentProof extends Component
{
    public $orderBillingId;

    public function mount($id)
    {
        $this->orderBillingId = $id;
    }

    public function render()
    {
        $proofs = GcashPayment::where('billing_id', $this->orderBillingId)->get();

        return view('livewire.billing.payment-proof', compact('proofs'));
    }
}
