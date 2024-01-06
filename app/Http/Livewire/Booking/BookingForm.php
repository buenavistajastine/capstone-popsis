<?php

namespace App\Http\Livewire\Booking;

use Exception;
use Carbon\Carbon;
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
    public $customer_id, $package_id, $venue_id, $venue_name, $venue_address, $remarks, $no_pax, $date_event, $call_time, $total_price, $dt_booked, $status_id;
    public $dishItems = [];
    public $addOns = [];
    public $selectedDishes = [];
    public $selectedMenus = [];
    public $quantity;
    public $event_name;
    public $action = '';
    public $message = '';

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


    public function bookingId($bookingId)
    {
        $this->bookingId = $bookingId;

        $booking = Booking::whereId($bookingId)->with('customers')->first();
        // dd($booking);
        // if ($booking->customers) {
        //     $this->customer_id = $booking->customer_id;
        //     $this->fill([
        //         'first_name' => $booking->customers->first_name,
        //         'middle_name' => $booking->customers->middle_name,
        //         'last_name' => $booking->customers->last_name,
        //         'contact_no' => $booking->customers->contact_no,
        //         'gender_id' => $booking->customers->gender_id,
        //     ]);
        // }

        if ($booking) {
            $this->customer_id = $booking->customer_id;
            $this->fill([
                'first_name' => optional($booking->customers)->first_name,
                'middle_name' => optional($booking->customers)->middle_name,
                'last_name' => optional($booking->customers)->last_name,
                'contact_no' => optional($booking->customers)->contact_no,
                'gender_id' => optional($booking->customers)->gender_id,
            ]);

            $this->package_id = $booking->package_id;
            $this->venue_id = $booking->venue_id;
            $this->event_name = $booking->event_name;
            $this->venue_address = $booking->venue_address;
            $this->no_pax = $booking->no_pax;
            $this->date_event = $booking->date_event;
            $this->call_time = $booking->call_time;
            $this->total_price = $booking->total_price;
            $this->dt_booked = $booking->dt_booked;
            $this->remarks = $booking->remarks;
            $this->status_id = $booking->status_id;
        } else {
            $this->package_id = null;
            $this->venue_id = null;
            $this->event_name = null;
            $this->venue_address = null;
            $this->no_pax = null;
            $this->date_event = null;
            $this->call_time = null;
            $this->total_price = null;
            $this->dt_booked = null;
            $this->remarks = null;
            $this->status_id = null;
        }

        // $this->package_id = $booking->package_id;
        // $this->venue_id = $booking->venue_id;
        // $this->venue_name = $booking->venue_name;
        // $this->venue_address = $booking->venue_address;
        // $this->no_pax = $booking->no_pax;
        // $this->date_event = $booking->date_event;
        // $this->call_time = $booking->call_time;
        // $this->total_price = $booking->total_price;
        // $this->dt_booked = $booking->dt_booked;
        // $this->remarks = $booking->remarks;
        // $this->status_id = $booking->status_id;

        $dishes = BookingDishKey::where('booking_id', $bookingId)->get();
        $addOnDishes = AddOn::where('booking_id', $bookingId)->get();

        // $this->dishItems = [];
        // $this->addOns = [];
        $i = 0;

        if ($dishes == null) {
            $this->dishItems[$i] = [
                'id' => null,
                'dish_id' => null,
                'quantity' => null,
            ];
        } else {
            foreach ($dishes as $dish) {
                $this->dishItems[$i] = [
                    'id' => $dish->id,
                    'dish_id' => $dish->dish_id,
                    'quantity' => $dish->quantity,
                ];
                $i++;
            }
        }

        if ($addOnDishes == null) {
            $this->addOns[$i] = [
                'id' => null,
                'dish_id' => null,
                'quantity' => null,
            ];
        } else {
            foreach ($addOnDishes as $add) {
                $this->addOns[$i] = [
                    'id' => $add->id,
                    'dish_id' => $add->dish_id,
                    'quantity' => $add->quantity,
                ];
                $i++;
            }
        }

        $this->selectedMenus = Menu::pluck('id')->toArray();
        $billing = Billing::where('booking_id', $this->bookingId)->first();
        $this->calculateTotalPrice();
    }

    // public function loadCustomerDetails()
    // {
    //     $selectedCustomer = Customer::find($this->customer_id);

    //     if ($selectedCustomer) {
    //         $this->fill([
    //             'first_name' => $selectedCustomer->first_name,
    //             'middle_name' => $selectedCustomer->middle_name,
    //             'last_name' => $selectedCustomer->last_name,
    //             'contact_no' => $selectedCustomer->contact_no,
    //         ]);
    //     } else {
    //         $this->fill([
    //             'first_name' => null,
    //             'middle_name' => null,
    //             'last_name' => null,
    //             'contact_no' => null,
    //         ]);
    //     }
    // }


    public function addDish()
    {
        $this->dishItems[] = [
            'id' => null,
            'dish_id' => '',
            'quantity' => 1,
        ];
    }

    public function addOnDish()
    {
        $this->addOns[] = [
            'id' => null,
            'dish_id' => '',
            'quantity' => 1,
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
                'event_name' => 'nullable',
                'venue_address' => 'nullable',
                'no_pax' => 'required',
                'date_event' => 'nullable',
                'call_time' => 'nullable',
                'total_price' => 'nullable',
                'dt_booked' => 'nullable',
                'remarks' => 'nullable',
                'status_id' => 'nullable',
            ]);


            if (!$this->customer_id) {
                $newCustomer = Customer::create($customer_data);
                $booking_data['customer_id'] = $newCustomer->id;
            } else {
                $booking_data['customer_id'] = $this->customer_id;
            }

            if (!$booking_data['total_price']) {
                $booking_data['total_price'] = 0;
            }

            if ($this->bookingId) {


                $booking = Booking::find($this->bookingId);

                $booking->update($booking_data, ['status_id' => 2]);
                $booking_services = BookingDishKey::where('booking_id', $this->bookingId)->get();

                // $billing = Billing::where('booking_id', $this->bookingId)->first();
                // $billing->update([
                //     'total_amt' => $booking_data['total_price'],
                //     'payable_amt' => $booking_data['total_price']
                // ]);

                foreach ($this->dishItems as $key => $value) {
                    if ($this->dishItems[$key]['id'] == null) {
                        BookingDishKey::create([
                            'booking_id' => $this->bookingId,
                            'dish_id' => $this->dishItems[$key]['dish_id'],
                            'quantity' => $this->dishItems[$key]['quantity'],
                            'update' => true
                        ]);
                    } else {
                        $dish_ni = BookingDishKey::find($this->dishItems[$key]['id']);
                        $dish_ni->update([
                            'booking_id' => $this->bookingId,
                            'dish_id' => $this->dishItems[$key]['dish_id'],
                            'quantity' => $this->dishItems[$key]['quantity'],
                            'update' => true
                        ]);
                    }
                }

                foreach ($this->addOns as $key => $value) {
                    if ($this->addOns[$key]['id'] == null) {
                        AddOn::create([
                            'booking_id' => $this->bookingId,
                            'dish_id' => $this->addOns[$key]['dish_id'],
                            'quantity' => $this->addOns[$key]['quantity'],
                            'update' => true
                        ]);
                    } else {
                        $dish_ni = AddOn::find($this->addOns[$key]['id']);
                        $dish_ni->update([
                            'booking_id' => $this->bookingId,
                            'dish_id' => $this->addOns[$key]['dish_id'],
                            'quantity' => $this->addOns[$key]['quantity'],
                            'update' => true
                        ]);
                    }
                }

                foreach ($this->dishItems as $key => $value) {
                    BookingDishKey::where('booking_id', '=', $this->bookingId)
                        ->update(['update' => 0]);
                }

                foreach ($this->addOns as $key => $value) {
                    AddOn::where('booking_id', '=', $this->bookingId)
                        ->update(['update' => 0]);
                }

                $action = "edit";
                $message = 'Successfully Updated';
            } else {

                $booking_data['status_id'] = 1;

                $booking_data['dt_booked'] = Carbon::now();



                // $booking_data['event_date'] = Carbon::parse($this->event_date);

                // $booking_data['call_time'] = Carbon::parse($this->call_time);                
                $booking = Booking::create($booking_data);

                $currentYear = Carbon::now()->year;
                $paddedRowId = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
                $result = $currentYear . $paddedRowId;

                // dd($result);
                $booking->update([
                    'booking_no' => $result
                ]);

                
                // $billing = Billing::create([
                //     'customer_id' => $booking->customer_id,
                //     'booking_id' => $booking->id,
                //     'total_amt' => $booking_data['total_price'],
                //     'payable_amt' => $booking_data['total_price'],
                //     'status' => 6
                // ]);
                // dd($billing->customer_id);
                foreach ($this->dishItems as $key => $value) {
                    BookingDishKey::create([
                        'booking_id' => $booking->id,
                        'dish_id' => $this->dishItems[$key]['dish_id'],
                        'quantity' => $this->dishItems[$key]['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                foreach ($this->addOns as $key => $value) {
                    AddOn::create([
                        'booking_id' => $booking->id,
                        'dish_id' => $this->addOns[$key]['dish_id'],
                        'quantity' => $this->addOns[$key]['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                $action = "store";
                $message = 'Successfully Created';
            }

            // dd('hello');
            $action = "store";
            $message = 'Successfully Created';
            DB::commit();

            BookingDishKey::where('booking_id', '=', $this->bookingId)
                ->whereNotIn('dish_id', collect($this->dishItems)->pluck('dish_id')->toArray())
                ->delete();

            AddOn::where('booking_id', '=', $this->bookingId)
                ->whereNotIn('dish_id', collect($this->addOns)->pluck('dish_id')->toArray())
                ->delete();

            $this->emit('flashAction', $action, $message);
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

    public function calculateTotalPrice()
    {
        $packagePrice = 0;
        $addOnPrice = 0;

        if (isset($this->package_id)) {
            $package = Package::find($this->package_id);

            if ($package) {
                $packagePrice = $package->price ?? 0;
            }
        }

        foreach ($this->addOns as $addOn) {
            if (!empty($addOn['dish_id'])) {
                $add = Dish::find($addOn['dish_id']);
        
                if ($add) {
                    $addOnPrice += ($add->price_full * $addOn['quantity']);
                }
            }
        }
        

        $total = $packagePrice * $this->no_pax;
        $overallPrice = $total + $addOnPrice;
        $this->total_price = $overallPrice;
    }


    public function deleteDish($dishIndex)
    {
        unset($this->dishItems[$dishIndex]);
        $this->dishItems = array_values($this->dishItems);
    }

    public function deleteAddOnDish($addOnIndex)
    {
        unset($this->addOns[$addOnIndex]);
        $this->addOns = array_values($this->addOns);
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
