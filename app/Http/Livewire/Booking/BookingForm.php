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
use App\Models\Venue;
use Illuminate\Support\Facades\DB;

class BookingForm extends Component
{
    public $bookingId, $packageId, $first_name, $middle_name, $last_name, $contact_no, $gender_id, $additional_amt, $advance_amt, $discount_amt;
    public $customer_id, $package_id, $venue_id, $venue_name, $venue_address, $remarks, $no_pax, $date_event, $call_time, $total_price, $dt_booked, $status_id;
    public $dishItems = [];
    public $selectedVenue, $city, $barangay, $specific_address, $landmark;
    public $packageDescription;
    public $maxFormRepeaters = 0;
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

        $this->dishItems = [];
        $this->addOns = [];

        $booking = Booking::whereId($bookingId)->with('customers')->first();

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
            $this->selectedVenue = $booking->venue_id;
            $this->city = $booking->city;
            $this->barangay = $booking->barangay;
            $this->specific_address = $booking->specific_address;
            $this->landmark = $booking->landmark;
            $this->event_name = $booking->event_name;
            $this->venue_address = $booking->venue_address;
            $this->no_pax = $booking->no_pax;
            $this->date_event = $booking->date_event;
            $this->call_time = $booking->call_time;
            $this->total_price = number_format($booking->total_price, 2);
            $this->dt_booked = $booking->dt_booked;
            $this->remarks = $booking->remarks;
            $this->status_id = $booking->status_id;
        } else {
            $this->package_id = null;
            $this->selectedVenue = null;
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

        $dishes = BookingDishKey::where('booking_id', $bookingId)->get();
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

        $addOnDishes = AddOn::where('booking_id', $bookingId)->get();
        $j = 0;

        if ($addOnDishes == null) {
            $this->addOns[$j] = [
                'id' => null,
                'dish_id' => null,
                'quantity' => null,
            ];
        } else {
            foreach ($addOnDishes as $add) {
                $this->addOns[$j] = [
                    'id' => $add->id,
                    'dish_id' => $add->dish_id,
                    'quantity' => $add->quantity,
                ];
                $j++;
            }
        }

        $this->selectedMenus = Menu::pluck('id')->toArray();
        $billing = Billing::where('booking_id', $this->bookingId)->first();
        $this->additional_amt = number_format($billing->additional_amt ?? 0, 2);
        $this->advance_amt = number_format($billing->advance_amt ?? 0, 2);
        $this->discount_amt = number_format($billing->discount_amt ?? 0, 2);
        $this->calculateTotalPrice();
    }

    public function updatedDishItems()
    {
        // Recalculate the total quantity of all dishes whenever the dishItems are updated
        $totalDishes = array_reduce($this->dishItems, function ($carry, $item) {
            $dish = Dish::find($item['dish_id']);
            if ($dish) {
                $carry += $item['quantity'];
            }
            return $carry;
        }, 0);
    
        // Check if the total dishes exceed the limitation
        $package = Package::find($this->package_id);
        if ($package && $package->limitation_of_maindish > 0) {
            $this->maxFormRepeaters = max(0, $package->limitation_of_maindish - $totalDishes);
        } else {
            $this->maxFormRepeaters = 0;
        }
    }
    
    public function addDish()
    {
        // Ensure that the total quantity does not exceed the maximum form repeaters
        if (count($this->dishItems) < $this->maxFormRepeaters) {
            $this->dishItems[] = [
                'id' => null,
                'dish_id' => '',
                'quantity' => 1,
            ];
        }
    }

    public function updatedPackageId()
    {
        $package = Package::find($this->package_id);
        
        if ($package) {
            $this->packageDescription = $package->description;
        }

        $this->updatedDishItems();
        $this->calculateTotalPrice();
    }

    
    public function addOnDish()
    {
        $this->addOns[] = [
            'id' => null,
            'dish_id' => '',
            'quantity' => 1,
        ];

        $this->calculateTotalPrice();
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
                'selectedVenue' => 'required',
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
                'event_name' => 'nullable',
                'venue_address' => 'nullable',
                'no_pax' => 'required',
                'date_event' => 'nullable',
                'call_time' => 'nullable',
                'total_price' => 'nullable',
                'dt_booked' => 'nullable',
                'remarks' => 'nullable',
                'status_id' => 'nullable',
                'additional_amt' => 'nullable', // Add this line
                'advance_amt' => 'nullable', // Add this line
                'discount_amt' => 'nullable', // Add this line
            ]);

            $booking_data['total_price'] = str_replace(['₱', ' ', ','], '', $booking_data['total_price']);
            $booking_data['venue_id'] = $this->selectedVenue;

            $additionalAmt = str_replace(',', '', $booking_data['additional_amt'] ?? 0);
            $advanceAmt = str_replace(',', '', $booking_data['advance_amt'] ?? 0);
            $discountAmt = str_replace(',', '', $booking_data['discount_amt'] ?? 0);

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

                $billing = Billing::where('booking_id', $this->bookingId)->first();
                if ($billing) {
                    $billing->update([
                        'total_amt' => $booking_data['total_price'],
                        'payable_amt' => $booking_data['total_price'],
                        'additional_amt' => $additionalAmt,
                        'advance_amt' => $advanceAmt,
                        'discount_amt' => $discountAmt,
                    ]);
                } else {
                    // Create billing if it does not exist
                    Billing::create([
                        'customer_id' => $booking->customer_id,
                        'booking_id' => $booking->id,
                        'total_amt' => $booking_data['total_price'],
                        'payable_amt' => $booking_data['total_price'],
                        'additional_amt' => $additionalAmt,
                        'advance_amt' => $advanceAmt,
                        'discount_amt' => $discountAmt,
                        'status_id' => 6,
                    ]);
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

                
                Billing::create([
                    'customer_id' => $booking->customer_id,
                    'booking_id' => $booking->id,
                    'total_amt' => $booking_data['total_price'],
                    'payable_amt' => $booking_data['total_price'],
                    'additional_amt' => $additionalAmt,
                    'advance_amt' => $advanceAmt,
                    'discount_amt' => $discountAmt,
                    'status_id' => 6,
                ]);
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
    
        if (!empty($this->package_id)) {
            $package = Package::find($this->package_id);
    
            if ($package) {
                $packagePrice = $package->price ?? 0;
            }
        }
    
        foreach ($this->addOns as $addOn) {
            if (!empty($addOn['dish_id'])) {
                $add = Dish::find($addOn['dish_id']);
    
                if ($add) {
                    // Ensure that price_full is numeric before multiplying
                    $addOnPrice += (float) $add->price_full * (int) $addOn['quantity'];
                }
            }
        }
    
        // Ensure that no_pax is set and is a numeric value
        $noPax = is_numeric($this->no_pax) ? $this->no_pax : 0;
    
        if ($this->total_price < 0) {
            $this->total_price = 0;
        }
    
        $total = $packagePrice * $noPax;
        $overallPrice = $total + $addOnPrice;

            // Ensure that additional_amt, advance_amt, and discount_amt are numeric
        $additionalAmt = is_numeric(str_replace(',', '', $this->additional_amt)) ? str_replace(',', '', $this->additional_amt) : 0;
        $advanceAmt = is_numeric(str_replace(',', '', $this->advance_amt)) ? str_replace(',', '', $this->advance_amt) : 0;
        $discountAmt = is_numeric(str_replace(',', '', $this->discount_amt)) ? str_replace(',', '', $this->discount_amt) : 0;

        $addedOverallPrice = $overallPrice + $additionalAmt;
        $advanceOverallPrice = $addedOverallPrice - $advanceAmt;
        $discountOverallPrice = $advanceOverallPrice - $discountAmt;
    
        // Format the overall price with two decimal places and commas
        $this->total_price = '₱ ' . number_format($discountOverallPrice, 2);
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

        $this->calculateTotalPrice();
    }

    public function mount()
    {
        $this->resetInputFields();

        $this->dishItems = [];
        $this->addOns = [];
    }

    public function updatePackages()
    {
        // This method will be called when the selected venue is changed
        $this->reset('package_id'); // Reset the selected package when venue changes
        $this->calculateTotalPrice(); // You may need to recalculate the total price based on the new packages
    }

    public function render()
    {
        $customers = Customer::all();
        $dishes = Dish::all();
        // $packages = Package::all(); 
        $menus = Menu::all();
        $venues = Venue::all();
        $selectedVenue = Venue::find($this->selectedVenue);
    
        $packages = [];
        if ($selectedVenue) {
            $packages = Package::where('venue_id', $selectedVenue->id)->get();
        }

        return view('livewire.booking.booking-form', compact('packages', 'dishes', 'customers', 'menus', 'venues'));
    }
}
