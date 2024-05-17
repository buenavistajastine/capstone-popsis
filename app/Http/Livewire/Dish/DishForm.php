<?php

namespace App\Http\Livewire\Dish;

use App\Models\Dish;
use App\Models\Menu;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DishForm extends Component
{
    use WithFileUploads;
    public $dishId, $menu_id, $name, $type_id, $description, $price_full, $price_half, $photo;
    public $action = '';
    public $message = '';

    protected $listeners = [
        'dishId',
        'resetInputFields',
        'updatePhotoPreview'
    ];

    public function updatedPhoto($photo)
    {
        $this->validate([
            'photo' => 'image|max:5120', // Example validation rule for image size
        ]);

        $this->emit('photoPreview', $photo->temporaryUrl());
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

    public function dishId($dishId)
    {
        $this->dishId = $dishId;
        $dish = Dish::whereId($dishId)->first();
        $this->menu_id = $dish->menu_id;
        $this->name = $dish->name;
        $this->type_id = $dish->type_id;
        $this->description = $dish->description;
        $this->price_full = number_format($dish->price_full, 2);
        $this->price_half = number_format($dish->price_half, 2);
        $this->photo = $dish->photo;
    }


    public function store()
    {
        $data = $this->validate([
            'menu_id' => 'required',
            'name' => 'required',
            'type_id' => 'nullable',
            'description' => 'nullable',
            'price_full' => 'nullable',
            'price_half' => 'nullable',
        ]);

        $data['price_full'] = str_replace(',', '', $data['price_full']);
        $data['price_half'] = str_replace(',', '', $data['price_half']);

        $filename = null;
        if ($this->photo instanceof \Illuminate\Http\UploadedFile) {
            // If $this->photo is an uploaded file instance
            $dish = $this->dishId ? Dish::find($this->dishId) : null;

            if ($dish && $dish->photo) {
                Storage::delete('public/dishImage/' . $dish->photo);
            }

            $filename = date('YmdHi') . '_' . $this->photo->getClientOriginalName();
            $this->photo->storeAs('public/dishImage', $filename);
        } elseif (is_string($this->photo)) {
            // If $this->photo is already a string (file name), no need to process it
            $filename = $this->photo;
        }

        $data['photo'] = $filename;

        if ($this->dishId) {
            Dish::whereId($this->dishId)->first()->update($data);
            $action = 'edit';
            $message = 'Successfully Updated';
        } else {
            Dish::create($data);
            $action = 'store';
            $message = 'Successfully Created';
        }

        $this->emit('flashAction', $action, $message);
        $this->resetInputFields();
        $this->emit('closeDishModal');
        $this->emit('refreshParentDish');
        $this->emit('refreshTable');
    }

    public function render()
    {
        $menus = Menu::all();
        $types = Type::all();
        return view('livewire.dish.dish-form', compact('menus', 'types'));
    }
}
