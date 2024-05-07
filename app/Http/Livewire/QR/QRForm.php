<?php

namespace App\Http\Livewire\QR;

use App\Models\QR;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class QRForm extends Component
{
    use WithFileUploads;
    public $qr_code, $qrId;

    protected $listeners = [
        'qrId',
        'resetInputFields',
        'updatePhotoPreview'
    ];

    public function updatedQrCode($qr_code)
    {
        $this->validate([
            'qr_code' => 'image|max:6144', // Validate photo upload
        ]);

        $this->emit('photoPreview', $qr_code->temporaryUrl());
    }

    public function updatePhotoPreview($photoUrl)
    {
        $this->emit('photoPreview', $photoUrl);
    }

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    //edit
    public function qrId($qrId)
    {
        $this->qrId = $qrId;
        $qr = QR::find($qrId);
        $this->qr_code = $qr->qr_code;
    }

    public function store()
    {
        $this->validate([
            'qr_code' => 'image|max:6144', // Validate photo upload
        ]);

        if ($this->qr_code) {
            // Retrieve the existing QR code if editing
            $qr = $this->qrId ? QR::find($this->qrId) : null;

            // Delete the old image if it exists
            if ($qr && $qr->qr_code) {
                Storage::delete('public/qrCode/' . $qr->qr_code);
            }

            // Store the new image
            $filename = date('YmdHi') . '_' . $this->qr_code->getClientOriginalName();
            $this->qr_code->storeAs('public/qrCode', $filename);

            // Create or update QR code entry
            if ($qr) {
                $qr->update(['qr_code' => $filename]);
            } else {
                QR::create(['qr_code' => $filename]);
            }

            // Reset input fields after successful upload
            $this->reset(['qr_code', 'qrId']);
            $this->emit('resetInputFields');
        }

        // You might want to return something meaningful here
        // or handle it based on your application logic
        $this->emit('flashAction', $this->qrId ? 'edit' : 'store', 'Successfully ' . ($this->qrId ? 'Updated' : 'Created'));

            // Reset input fields and close modal
            $this->resetInputFields();
            $this->emit('closeQRModal');
            $this->emit('refreshParentQR');
            $this->emit('refreshTable');
    }

    public function render()
    {
        return view('livewire.q-r.q-r-form');
    }
}
