<?php

namespace App\Http\Livewire\Dish;

use App\Models\Dish;
use App\Models\Menu;
use Livewire\Component;

class DishForm extends Component
{
    public $dishId, $menu_id, $name, $description, $price;
    public $action = '';
    public $message = '';

    protected $listeners = [
        'dishId',
        'resetInputFields'
    ];

    public function resetInputFields() {
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
        $this->description = $dish->description;
        $this->price = $dish->price;
    }

    public function store() {
        $data = $this->validate([
            'menu_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required',
        ]);

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
        return view('livewire.dish.dish-form', compact('menus'));
    }
}
