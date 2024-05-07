<?php

namespace App\Http\Livewire\QR;

use App\Models\QR;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class QRCode extends Component
{

    use WithFileUploads;

    public $qrId;

    protected $listeners = [
        'refreshParentQR' => '$refresh',
    ];

    public function createQR()
    {
        $this->emit('resetInputFields');
        $this->emit('openQRModal');
    }

    public function editQR($qrId)
    {
        $this->qrId = $qrId;
        $this->emit('qrId', $this->qrId);
        $this->emit('openQRModal');
    }

    public function deleteQR($qrId)
    {
        $qr = QR::find($qrId);
        Storage::delete('public/qrCode/' . $qr->qr_code);
        $qr->delete();

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }
    
    public function render()
    {
        $qrcodes = QR::all();

        return view('livewire.q-r.q-r-code', compact('qrcodes'));
    }
}
