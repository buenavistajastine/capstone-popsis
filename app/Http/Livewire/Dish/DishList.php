<?php

namespace App\Http\Livewire\Dish;

use App\Models\Dish;
use App\Models\Menu;
use Livewire\Component;
use Livewire\WithPagination;

class DishList extends Component
{
    use WithPagination;
    
    public $dishId;
    public $search = '';
    public $selectedMenuFilter;

    protected $listeners = [
        'refreshParentDish' => '$refresh',
        'deleteDish',
        'editDish',
        'deleteConfirmDish'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createDish()
    {
        $this->emit('resetInputFields');
        $this->emit('openDishModal');
    }

    public function editDish($dishId)
    {
        $this->dishId = $dishId;
        $this->emit('dishId', $dishId);
        $this->emit('openDishModal');
    }

    public function deleteDish($dishId)
    {
        Dish::destroy($dishId);

        $action = 'error';
        $message = 'Successfully Deleted';

        $this->emit('flashAction', $action, $message);
        $this->emit('refreshTable');
    }

    public function applyMenuFilter($menuId)
    {
        $this->selectedMenuFilter = $menuId;
        $this->resetPage();
    }

    public function render()
    {
        $dishes = Dish::when($this->selectedMenuFilter, function ($query, $menuId) {
                return $query->where('menu_id', $menuId);
            })
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('menu', function ($menuQuery) {
                        $menuQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate(10);

        $menus = Menu::all();

        return view('livewire.dish.dish-list', compact('dishes', 'menus'));
    }
}
