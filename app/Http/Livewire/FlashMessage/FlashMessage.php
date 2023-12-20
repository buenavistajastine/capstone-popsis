<?php

namespace App\Http\Livewire\FlashMessage;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message;

    protected $listeners = [
        'flashAction'
    ];

    public function render()
    {
        return view('livewire.flash-message.flash-message');
    }

    public function flashAction($action, $message)
    {
        $this->message = $message;

        if ($action == 'store') {
            session()->flash('success', $this->message);
        } elseif ($action == 'edit') {
            session()->flash('info', $this->message);
        } elseif ($action == 'delete') {
            session()->flash('delete', $this->message);
        } elseif ($action == 'warning') {
            session()->flash('warning', $this->message);
        } else {
            session()->flash('error', $this->message);
        }
    }
}
