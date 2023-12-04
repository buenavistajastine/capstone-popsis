<?php

namespace App\Http\Livewire\Booking;

use Exception;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\AddOn;
use App\Models\Billing;
use App\Models\Booking;
use App\Models\Package;
use Livewire\Component;
use App\Models\Customer;
use App\Models\BookingDishKey;
use Illuminate\Support\Facades\DB;

class BookingForm extends Component
{
    public $bookingId, $packageId, $first_name, $middle_name, $last_name, $contact_no, $gender_id;
    public $customer_id, $package_id, $venue_id, $venue_address, $remarks, $no_pax, $date_event, $call_time, $total_price, $dt_booked, $status_id;
    public $dishItems = [];
    public $addOns = [];
    public $selectedDishes = [];
    public $selectedMenus = [];
    public $action = '';
    public $message = '';

    protected $rules = [
        'first_name' => 'required',
        'middle_name' => 'nullable',
        'last_name' => 'required',
        'contact_no' => 'nullable',
        'gender_id' => 'nullable',
        'package_id' => 'required',
        'venue_id' => 'nullable',
        'venue_address' => 'nullable',
        'no_pax' => 'required',
        'date_event' => 'required',
        'call_time' => 'required',
        'total_price' => 'nullable',
        'dt_booked' => 'nullable',
        'remarks' => 'nullable',
        'status_id' => 'nullable',
        'selectedMenus.*' => 'required|exists:menus,id',
    ];

    protected $listeners = [
        'bookingId',
        'resetInputFields',
    ];

    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function mount()
    {
        $this->selectedMenus = Menu::pluck('id')->toArray();

        foreach ($this->selectedMenus as $menuId) {
            $this->dishItems[$menuId] = [
                [
                    'id' => null,
                    'dish_id' => null,
                    'quantity' => null,
                ]
            ];
            $this->selectedDishes[$menuId] = collect();
        }
    }


    public function bookingId($bookingId)
    {
        $this->bookingId = $bookingId;

        $booking = Booking::with('customer')->find($bookingId);

        if ($booking->customer) {
            $this->customer_id = $booking->customer_id;
            $this->fill([
                'first_name' => $booking->customer->first_name,
                'middle_name' => $booking->customer->middle_name,
                'last_name' => $booking->customer->last_name,
                'contact_no' => $booking->customer->contact_no,
                'gender_id' => $booking->customer->gender_id,
            ]);
        }

        $this->package_id = $booking->package_id;
        $this->venue_id = $booking->venue_id;
        $this->venue_address = $booking->venue_address;
        $this->no_pax = $booking->no_pax;
        $this->date_event = $booking->date_event;
        $this->call_time = $booking->call_time;
        $this->total_price = $booking->total_price;
        $this->dt_booked = $booking->dt_booked;
        $this->remarks = $booking->remarks;
        $this->status_id = $booking->status_id;

        $dishes = BookingDishKey::where('booking_id', $bookingId)->get();

        $this->dishItems = [];
        $this->addOns = [];

        foreach ($dishes as $value) {
            $this->dishItems[] = [
                'id' => $value->id,
                'dish_id' => $value->dish_id,
                'quantity' => $value->quantity,
                'dt_accepted' => $value->dt_accepted,
                'dt_completed' => $value->dt_completed,
            ];
            $this->addOns[] = [
                'id' => $value->id,
                'addon_id' => $value->addon_id,
                'quantity' => $value->quantity,
                'dt_accepted' => $value->dt_accepted,
                'dt_completed' => $value->dt_completed,
            ];
        }

        $this->selectedMenus = Menu::pluck('id')->toArray();
        $billing = Billing::where('booking_id', $this->bookingId)->first();
    }

    public function loadCustomerDetails()
    {
        $selectedCustomer = Customer::find($this->customer_id);

        if ($selectedCustomer) {
            $this->first_name = $selectedCustomer->first_name;
            $this->middle_name = $selectedCustomer->middle_name;
            $this->last_name = $selectedCustomer->last_name;
            $this->contact_no = $selectedCustomer->contact_no;
        } else {
            $this->first_name = null;
            $this->middle_name = null;
            $this->last_name = null;
            $this->contact_no = null;
        }
    }

    public function loadDishes($dishIndex)
    {
        $menuId = $this->selectedMenus[$dishIndex];
        $dishes = Dish::where('menu_id', $menuId)->get();

        $this->selectedDishes[$menuId] = $dishes;
    }


    public function updatedDishItems($value, $dishIndex)
    {
        $this->loadDishes($dishIndex);
    }

    public function addDish($menuId)
    {
        $this->dishItems[$menuId][] = [
            'id' => null,
            'dish_id' => null,
            'quantity' => null,
        ];
    }

    public function store()
    {
        $booking = Booking::find($this->bookingId);

        try {
            DB::beginTransaction();

            $customer_data = $this->validate([
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'contact_no' => 'nullable',
                'gender_id' => 'nullable',
            ]);

            $booking_data = $this->validate([
                'package_id' => 'required',
                'venue_id' => 'nullable',
                'venue_address' => 'nullable',
                'no_pax' => 'required',
                'date_event' => 'required',
                'call_time' => 'required',
                'total_price' => 'nullable',
                'dt_booked' => 'nullable',
                'remarks' => 'nullable',
                'status_id' => 'nullable',
            ]);

            if (empty($this->customer_id)) {
                $newCustomer = Customer::create($customer_data);
                $booking_data['customer_id'] = $newCustomer->id;
            } else {
                $booking_data['customer_id'] = $this->customer_id;
            }

            $booking->update($booking_data);

            foreach ($this->dishItems as $key => $value) {
                BookingDishKey::updateOrCreate(
                    ['id' => $value['id']],
                    [
                        'booking_id' => $this->bookingId,
                        'dish_id' => $value['dish_id'],
                        'quantity' => $value['quantity'],
                    ]
                );
            }

            foreach ($this->addOns as $key => $value) {
                AddOn::updateOrCreate(
                    ['id' => $value['id']],
                    [
                        'booking_id' => $this->bookingId,
                        'addon_id' => $value['addon_id'],
                        'quantity' => $value['quantity'],
                    ]
                );
            }

            foreach ($this->dishItems as $key => $value) {
                $this->loadDishes($key);
            }

            DB::commit();

            $this->emit('flashAction', $this->action, $this->message);
            $this->resetInputFields();
            $this->emit('closeBookingModal');
            $this->emit('refreshParentBooking');
            $this->emit('refreshTable');
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();
            $this->emit('flashAction', 'error', $errorMessage);
        }
    }

    public function deleteDish($dishIndex)
    {
        unset($this->dishItems[$dishIndex]);
        $this->dishItems = array_values($this->dishItems);
    }

    public function render()
    {
        $customers = Customer::all();
        $dishes = Dish::all();
        $packages = Package::all();
        $menus = Menu::all();

        return view('livewire.booking.booking-form', compact('packages', 'dishes', 'customers', 'menus'));
    }
}
