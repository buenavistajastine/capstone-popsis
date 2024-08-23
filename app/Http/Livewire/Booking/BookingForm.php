<?php

namespace App\Http\Livewire\Booking;

use App\Events\BookingCreated;
use App\Events\OrderCreated;
use Exception;
use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\User;
use App\Models\AddOn;
use App\Models\Address;
use App\Models\Motif;
use App\Models\Venue;
use App\Models\Billing;
use App\Models\Booking;
use App\Models\Package;
use Livewire\Component;
use App\Models\Customer;
use App\Models\BookingDishKey;
use App\Models\CustomerAddress;
use App\Models\PaidAmount;
use Illuminate\Support\Facades\DB;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Notification;

class BookingForm extends Component
{
    public $order, $recordId;
    public $bookingId, $packageId, $first_name, $middle_name, $last_name, $contact_no, $gender_id, $additional_amt, $advance_amt, $discount_amt;
    public $customer_id, $package_id, $venue_id, $venue_name, $venue_address, $remarks, $no_pax, $date_event, $call_time, $total_price, $dt_booked, $status_id, $selectedIndex;
    public $dishItems = [];
    public $selectedVenue, $city, $barangay, $specific_address, $landmark;
    public $color, $color2;
    public $packageDescription;
    public $maxFormRepeaters = 0;
    public $addOns = [];
    public $selectedDishes = [];
    public $selectedAddOns = [];
    public $selectedMenus = [];
    public $quantity;
    public $event_name;
    public $activeTab = ['customer', 'address', 'booking'];
    public $action = '';
    public $message = '';
    public $search = '';
    public $totalBookingPrice, $totalAddOnPrice;
    public $can_rebook = false;

    public $customers = [];
    public $searchQuery = '';
    public $selectedCustomerId = null;
    public $errorMessage = '';

    protected $listeners = [
        'bookingId',
        'recordId',
        'resetInputFields',
        'reBook',
        'echo:bookings,BookingCreated' => 'handleBookingCreated'
    ];
    

    public function handleBookingCreated($event)
    {
        // Reload the data or refresh the table
        $this->emit('refreshTable');
    }


    public function resetInputFields()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
        $this->errorMessage = '';
    }


    public function selectCustomer($customerId)
    {
        $this->selectedCustomerId = $customerId;
        // Fetch the customer's details
        $customer = Customer::find($customerId);

        if ($customer) {
            $customer_address = CustomerAddress::where('customer_id', $customer->id)->first();
            $this->first_name = $customer->first_name;
            $this->last_name = $customer->last_name;
            $this->contact_no = $customer->contact_no;
            $this->city = $customer_address->city;
            $this->barangay = $customer_address->barangay;
            $this->specific_address = $customer_address->specific_address;
            $this->landmark = $customer_address->landmark;

            $this->searchQuery = $customer->first_name . ' ' . $customer->last_name;
        } else {
            $this->resetInputFields();
        }
    }


    public function bookingId($bookingId)
    {
        $this->bookingId = $bookingId;

        $this->dishItems = [];
        $this->addOns = [];

        $booking = Booking::whereId($bookingId)->with('customers')->first();
        $address = Address::where('booking_id', $bookingId)->first();

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
            $this->city = $address->city;
            $this->barangay = $address->barangay;
            $this->specific_address = $address->specific_address;
            $this->landmark = $address->landmark;
            $this->event_name = $booking->event_name;
            $this->venue_address = $address->venue_address;
            $this->no_pax = $booking->no_pax;
            $this->date_event = $booking->date_event;
            $this->call_time = $booking->call_time;
            $this->total_price = number_format($booking->total_price, 2);
            $this->dt_booked = $booking->dt_booked;
            $this->remarks = $booking->remarks;
            $this->status_id = $booking->status_id;
            $this->color = $booking->color ?? null;
            $this->color2 = $booking->color2 ?? null;
            $this->packageDescription = optional($booking->packages)->description;
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
            $this->color = null;
            $this->color2 = null;
        }

        $dishes = BookingDishKey::where('booking_id', $bookingId)->get();
        $this->selectedDishes = [];
        foreach ($dishes as $dish) {
            $this->selectedDishes[] = [
                'id' => $dish->dish_id,
                'name' => $dish->dishes->name,
                'quantity' => $dish->quantity,
                'type_id' => $dish->dishes->type->name

            ];
        }

        $addOnDishes = AddOn::where('booking_id', $bookingId)->get();
        $this->selectedAddOns = [];
        foreach ($addOnDishes as $addon) {
            $this->selectedAddOns[] = [
                'id' => $addon->dish_id,
                'name' => $addon->dishss->name,
                'quantity' => $addon->quantity,
                'type_id' => $addon->dishss->type->name
            ];
        }

        $now = Carbon::now();

        if ($booking->date_event < $now) {
            $this->can_rebook = true;
        }

        $this->selectedMenus = Menu::pluck('id')->toArray();
        $billing = Billing::where('booking_id', $this->bookingId)->first();
        $this->additional_amt = number_format($billing->additional_amt ?? 0, 2);
        $this->advance_amt = number_format($billing->advance_amt ?? 0, 2);
        $this->discount_amt = number_format($billing->discount_amt ?? 0, 2);
        $this->calculateTotalPrice();

        
    }


    public function addDish($dishId)
    {
        $dish = Dish::find($dishId);
        $this->selectedDishes[] = [
            'id' => $dish->id,
            'name' => $dish->name,
            'quantity' => 1,
            'type_id' => $dish->type->name // or $dish->type->id if using the foreign key
        ];
    }


    public function addAddOn($dishId)
    {
        $dish = Dish::find($dishId);
        $this->selectedAddOns[] = [
            'id' => $dish->id,
            'name' => $dish->name,
            'quantity' => 1,
            'type_id' => $dish->type->name // or $dish->type->id if using the foreign key
        ];

        $this->calculateTotalPrice();
    }


    public function isDishSelected($dishId)
    {
        return collect($this->selectedDishes)->contains('id', $dishId);
    }


    public function isAddOnSelected($dishId)
    {
        return collect($this->selectedAddOns)->contains('id', $dishId);
    }

    public function updateDishQuantity($index, $quantity)
    {
        $this->selectedDishes[$index]['quantity'] = $quantity;
    }


    public function updateAddOnQuantity($index, $quantity)
    {
        $this->selectedAddOns[$index]['quantity'] = $quantity;
        $this->calculateTotalPrice();
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


    public function removeDish($index)
    {
        unset($this->selectedDishes[$index]);
        $this->selectedDishes = array_values($this->selectedDishes);
    }


    public function removeAddOn($index)
    {
        unset($this->selectedAddOns[$index]);
        $this->selectedAddOns = array_values($this->selectedAddOns);

        $this->calculateTotalPrice();
    }


    public function updatePackages()
    {

        $this->reset('package_id');
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
                'event_name' => 'nullable',
                'no_pax' => 'required',
                'date_event' => 'required|date|after_or_equal:today',
                'call_time' => 'nullable',
                'total_price' => 'nullable',
                'dt_booked' => 'nullable',
                'remarks' => 'nullable',
                'status_id' => 'nullable',
                'additional_amt' => 'nullable',
                'advance_amt' => 'nullable',
                'discount_amt' => 'nullable',
                'color' => 'nullable',
                'color2' => 'nullable',
            ]);

            $address_data = $this->validate([
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
                'venue_address' => 'nullable',
            ]);

            $address_data2 = $this->validate([
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
            ]);

            if (empty($this->selectedDishes)) {
                $this->selectedDishes = [];
            }

            if (empty($this->selectedAddOns)) {
                $this->selectedAddOns = [];
            }

            $booking_data['total_price'] = str_replace(['₱', ' ', ','], '', $booking_data['total_price']);
            $booking_data['venue_id'] = $this->selectedVenue;

            $additionalAmt = str_replace(',', '', $booking_data['additional_amt'] ?? 0);
            $advanceAmt = str_replace(',', '', $booking_data['advance_amt'] ?? 0);
            $discountAmt = str_replace(',', '', $booking_data['discount_amt'] ?? 0);
            $totalPrice = str_replace(['₱', ' ', ','], '', $booking_data['total_price']);

            // Set the status_id based on advance_amt
            $billingStatusId = $advanceAmt != 0 ? 13 : 6;

            if (!$this->customer_id) {
                if (!$this->selectedCustomerId) {
                    $newCustomer = Customer::create($customer_data);
                    $booking_data['customer_id'] = $newCustomer->id;
                } else {
                    $booking_data['customer_id'] = $this->selectedCustomerId;
                }
            } else {
                $booking_data['customer_id'] = $this->customer_id;
                $cust = Customer::whereId($this->customer_id)->first();
                $user = User::whereId($cust->user_id)->first();
                if ($user) {
                    $user->update([
                        'first_name' => $this->first_name,
                        'middle_name' => $this->middle_name,
                        'last_name' => $this->last_name,
                    ]);
                }

                $cust->update([
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                ]);
            }

            if (!$booking_data['total_price']) {
                $booking_data['total_price'] = 0;
            }

            if ($this->bookingId) {
                $booking = Booking::find($this->bookingId);
                $address = Address::where('booking_id', $booking->id);

                $booking->update($booking_data);
                $address->update($address_data);

                // Update dishes and add-ons
                BookingDishKey::where('booking_id', $this->bookingId)->delete();
                foreach ($this->selectedDishes as $dish) {
                    BookingDishKey::create([
                        'booking_id' => $this->bookingId,
                        'dish_id' => $dish['id'],
                        'quantity' => $dish['quantity']
                    ]);
                }

                AddOn::where('booking_id', $this->bookingId)->delete();
                foreach ($this->selectedAddOns as $addOn) {
                    AddOn::create([
                        'booking_id' => $this->bookingId,
                        'dish_id' => $addOn['id'],
                        'quantity' => $addOn['quantity']
                    ]);
                }

                $billing = Billing::where('booking_id', $this->bookingId)->first();
                $paid_amounts = PaidAmount::where('billing_id', $billing->id)->first();
                if ($billing) {
                    $billing->update([
                        'total_amt' => $booking_data['total_price'],
                        'additional_amt' => $additionalAmt,
                        'advance_amt' => $advanceAmt,
                        'discount_amt' => $discountAmt,
                        'status_id' => $billingStatusId,
                    ]);

                    $paid_amounts->update([
                        'billing_id' => $billing->id,
                        'payable_amt' => $booking_data['total_price'],
                    ]);
                } else {
                    $billing = Billing::create([
                        'customer_id' => $booking->customer_id,
                        'booking_id' => $booking->id,
                        'total_amt' => $booking_data['total_price'],
                        'additional_amt' => $additionalAmt,
                        'advance_amt' => $advanceAmt,
                        'discount_amt' => $discountAmt,
                        'status_id' => $billingStatusId,
                    ]);

                    PaidAmount::create([
                        'billing_id' => $billing->id,
                        'payable_amt' => $booking_data['total_price'],
                    ]);
                }

                $action = 'edit';
                $message = 'Successfully Updated';
            } else {
                $booking_data['status_id'] = 2;
                $booking_data['dt_booked'] = Carbon::now();

                $booking = Booking::create($booking_data);
                $address_data['booking_id'] = $booking->id;
                Address::create($address_data);
                $address_data2['customer_id'] = $booking->customer_id;
                CustomerAddress::create($address_data2);
                

                $currentYear = "BKG";
                $paddedRowId = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
                $result = $currentYear . $paddedRowId;
                $booking->update(['booking_no' => $result]);

                $billing = Billing::create([
                    'customer_id' => $booking->customer_id,
                    'booking_id' => $booking->id,
                    'total_amt' => $booking_data['total_price'],
                    'additional_amt' => $additionalAmt,
                    'advance_amt' => $advanceAmt,
                    'discount_amt' => $discountAmt,
                    'status_id' => 6,
                ]);

                PaidAmount::create([
                    'billing_id' => $billing->id,
                    'payable_amt' => $booking_data['total_price'],
                ]);

                foreach ($this->selectedDishes as $dish) {
                    BookingDishKey::create([
                        'booking_id' => $booking->id,
                        'dish_id' => $dish['id'],
                        'quantity' => $dish['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                foreach ($this->selectedAddOns as $addOn) {
                    AddOn::create([
                        'booking_id' => $booking->id,
                        'dish_id' => $addOn['id'],
                        'quantity' => $addOn['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                $action = 'store';
                $message = 'Successfully Created';
            }

            DB::commit();

            BookingDishKey::where('booking_id', '=', $this->bookingId)
                ->whereNotIn('dish_id', collect($this->selectedDishes)->pluck('id')->toArray())
                ->delete();

            AddOn::where('booking_id', '=', $this->bookingId)
                ->whereNotIn('dish_id', collect($this->selectedAddOns)->pluck('id')->toArray())
                ->delete();

            $this->selectedDishes = [];
            $this->selectedAddOns = [];
            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeBookingModal');
            $this->emit('refreshParentBooking');
            $this->emit('refreshTable');
        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }


    public function calculateTotalPrice()
    {
        $packagePrice = 0;
        $addOnPrice = 0;

        // dd($this->selectedAddOns);

        if (!empty($this->package_id)) {
            $package = Package::find($this->package_id);

            if ($package) {
                $packagePrice = $package->price ?? 0;
            }
        }

        foreach ($this->selectedAddOns as $addOn) {
            if (!empty($addOn['id'])) {
                $dish = Dish::find($addOn['id']);

                if ($dish) {
                    if ($addOn['quantity'] == 0.5) {
                        $addOnPrice += (float) $dish->price_half;
                    } else {
                        $addOnPrice += (float) $dish->price_full * (int) $addOn['quantity'];
                    }
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

        $this->totalBookingPrice = $total;
        $this->totalAddOnPrice = $addOnPrice;

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

    // For ReBooking the existing booking record
    public function reBook()
    {
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
                'event_name' => 'nullable',
                'no_pax' => 'required',
                'date_event' => 'required|date|after_or_equal:today',
                'call_time' => 'nullable',
                'total_price' => 'nullable',
                'dt_booked' => 'nullable',
                'remarks' => 'nullable',
                'status_id' => 'nullable',
                'additional_amt' => 'nullable',
                'advance_amt' => 'nullable',
                'discount_amt' => 'nullable',
                'color' => 'nullable',
                'color2' => 'nullable',
            ]);

            $address_data = $this->validate([
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
                'venue_address' => 'nullable',
            ]);

            if (empty($this->selectedDishes)) {
                $this->selectedDishes = [];
            }

            if (empty($this->selectedAddOns)) {
                $this->selectedAddOns = [];
            }

            $booking_data['total_price'] = str_replace(['₱', ' ', ','], '', $booking_data['total_price']);
            $booking_data['venue_id'] = $this->selectedVenue;

            $additionalAmt = str_replace(',', '', $booking_data['additional_amt'] ?? 0);
            $advanceAmt = str_replace(',', '', $booking_data['advance_amt'] ?? 0);
            $discountAmt = str_replace(',', '', $booking_data['discount_amt'] ?? 0);
            $totalPrice = str_replace(['₱', ' ', ','], '', $booking_data['total_price']);

            // Set the status_id based on advance_amt
            $billingStatusId = $advanceAmt != 0 ? 13 : 6;

            if (!$this->customer_id) {
                if (!$this->selectedCustomerId) {
                    $newCustomer = Customer::create($customer_data);
                    $booking_data['customer_id'] = $newCustomer->id;
                } else {
                    $booking_data['customer_id'] = $this->selectedCustomerId;
                }
            } else {
                $booking_data['customer_id'] = $this->customer_id;
                $cust = Customer::whereId($this->customer_id)->first();
                $user = User::whereId($cust->user_id)->first();
                if ($user) {
                    $user->update([
                        'first_name' => $this->first_name,
                        'middle_name' => $this->middle_name,
                        'last_name' => $this->last_name,
                    ]);
                }

                $cust->update([
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                ]);
            }

            if ($this->bookingId) {
                $booking_data['status_id'] = 2;
                $booking_data['dt_booked'] = Carbon::now();

                $booking = Booking::create($booking_data);
                $address_data['booking_id'] = $booking->id;
                Address::create($address_data);

                $currentYear = "BKG";
                $paddedRowId = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
                $result = $currentYear . $paddedRowId;
                $booking->update(['booking_no' => $result]);

                $billing = Billing::create([
                    'customer_id' => $booking->customer_id,
                    'booking_id' => $booking->id,
                    'total_amt' => $booking_data['total_price'],
                    'additional_amt' => $additionalAmt,
                    'advance_amt' => $advanceAmt,
                    'discount_amt' => $discountAmt,
                    'status_id' => 6,
                ]);

                PaidAmount::create([
                    'billing_id' => $billing->id,
                    'payable_amt' => $booking_data['total_price'],
                ]);

                foreach ($this->selectedDishes as $dish) {
                    BookingDishKey::create([
                        'booking_id' => $booking->id,
                        'dish_id' => $dish['id'],
                        'quantity' => $dish['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                foreach ($this->selectedAddOns as $addOn) {
                    AddOn::create([
                        'booking_id' => $booking->id,
                        'dish_id' => $addOn['id'],
                        'quantity' => $addOn['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                $action = 'store';
                $message = 'Successfully Created';
            }

            DB::commit();

            BookingDishKey::where('booking_id', '=', $this->bookingId)
                ->whereNotIn('dish_id', collect($this->selectedDishes)->pluck('id')->toArray())
                ->delete();

            AddOn::where('booking_id', '=', $this->bookingId)
                ->whereNotIn('dish_id', collect($this->selectedAddOns)->pluck('id')->toArray())
                ->delete();

            $this->selectedDishes = [];
            $this->selectedAddOns = [];
            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeBookingModal');
            $this->emit('refreshParentBooking');
            $this->emit('refreshTable');
        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }


    public function render()
    {
        $booking = Booking::whereId($this->bookingId)->first();
        $customers = Customer::all();
        $dishes = Dish::where('name', 'like', "%{$this->search}%")->get();
        // $packages = Package::all(); 
        $menus = Menu::all();
        $venues = Venue::all();
        $selectedVenue = Venue::find($this->selectedVenue);

        if (strlen($this->searchQuery) > 0) {
            $this->customers = Customer::where('last_name', 'like', "%{$this->searchQuery}%")
                ->orWhere('first_name', 'like', "%{$this->searchQuery}%")
                ->orWhere('middle_name', 'like', "%{$this->searchQuery}%")
                ->get();
        }

        $packages = [];
        if ($selectedVenue) {
            $packages = Package::where('venue_id', $selectedVenue->id)->get();
        }

        return view('livewire.booking.booking-form', compact('packages', 'dishes', 'customers', 'menus', 'venues'));
    }
}
