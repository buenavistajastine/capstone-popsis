<?php

namespace App\Http\Livewire\FoodOrder;

use App\Events\OrderCreated;
use Exception;
use Carbon\Carbon;
use App\Models\Dish;
use App\Models\User;
use App\Models\Address;
use App\Models\Billing;
use Livewire\Component;
use App\Models\Customer;
use App\Models\FoodOrder;
use App\Models\CustomerAddress;
use App\Models\FoodOrderDishKey;
use Illuminate\Support\Facades\DB;
use App\Models\ModeOfTransportation;
use App\Models\PaidAmount;

class FoodOrderForm extends Component
{
    public $orderId;
    // customer
    public $first_name, $middle_name, $last_name, $contact_no, $gender_id;
    // food order
    public $customer_id, $quantity, $dish_id, $ordered_by, $date_need, $call_time, $total_price, $transport_id, $status_id, $remarks;
    public $city, $barangay, $specific_address, $landmark;
    public $dishItems = [];
    public $action = '';
    public $message = '';

    public $customers = [];
    public $searchQuery = '';
    public $selectedCustomerId = null;
    public $errorMessage = '';

    protected $listeners = [
        'orderId',
        'resetInputFields',
        'echo:orders,OrderCreated' => 'handleOrderCreated'
    ];

    public function handleOrderCreated($event)
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
    

    public function orderId($orderId)
    {
        $this->orderId = $orderId;

        $this->dishItems = [];

        $order = FoodOrder::whereId($orderId)->with('customers')->first();
        $address = CustomerAddress::where('customer_id', $order->customer_id)->first();

        if ($order) {
            $this->customer_id = $order->customer_id;
            $this->fill([
                'first_name' => optional($order->customers)->first_name,
                'middle_name' => optional($order->customers)->middle_name,
                'last_name' => optional($order->customers)->last_name,
                'contact_no' => optional($order->customers)->contact_no,
                'gender_id' => optional($order->customers)->gender_id,
            ]);

            $this->ordered_by = $order->ordered_by;
            $this->date_need = $order->date_need;
            $this->call_time = $order->call_time;
            $this->total_price = number_format($order->total_price, 2);
            $this->transport_id = $order->transport_id;
            $this->status_id = $order->status_id;
            $this->remarks = $order->remarks;
            $this->city = $address->city;
            $this->barangay = $address->barangay;
            $this->specific_address = $address->specific_address;
            $this->landmark = $address->landmark;
        } else {
            $this->ordered_by = null;
            $this->date_need = null;
            $this->call_time = null;
            $this->total_price = null;
            $this->transport_id = null;
            $this->status_id = null;
            $this->remarks = null;
            $this->city = null;
            $this->barangay = null;
            $this->specific_address = null;
            $this->landmark = null;
        }

        $dishes = FoodOrderDishKey::where('order_id', $orderId)->get();

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
    }

    public function store()
    {
        $order = FoodOrder::find($this->orderId);
        $newCustomer = null;

        try {
            DB::beginTransaction();

            $customer_data = $this->validate([
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'contact_no' => 'nullable',
                'gender_id' => 'nullable',
                'contact_no' => 'nullable',
            ]);

            $order_data = $this->validate([
                'ordered_by' => 'nullable',
                'date_need' => 'required|date|after_or_equal:today',
                'call_time' => 'required',
                'total_price' => 'required',
                'transport_id' => 'required',
                'status_id' => 'nullable',
                'remarks' => 'nullable',
            ]);

            $address_data = $this->validate([
                'city' => 'nullable',
                'barangay' => 'nullable',
                'specific_address' => 'nullable',
                'landmark' => 'nullable',
            ]);

            
            if (!$this->customer_id) {
                    if (!$this->selectedCustomerId) {
                        $newCustomer = Customer::create($customer_data);
                        $order_data['customer_id'] = $newCustomer->id;
                    } else {
                        $order_data['customer_id'] = $this->selectedCustomerId;
                    }
            } else {
                    $order_data['customer_id'] = $this->customer_id;

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

            // Assign the result of str_replace to 'total_price'
            $order_data['total_price'] = str_replace(['₱', ' ', ','], '', $order_data['total_price'] ?? 0);

            if ($this->orderId) {
                        $order = FoodOrder::find($this->orderId);
                      
                        $address = CustomerAddress::where('customer_id', $order->customer_id);

                        $order->update($order_data, ['status_id' => 2]);
                        $address->update($address_data);

                        foreach ($this->dishItems as $key => $value) {
                            if ($this->dishItems[$key]['id'] == null) {
                                FoodOrderDishKey::create([
                                    'order_id' => $this->orderId,
                                    'dish_id' => $this->dishItems[$key]['dish_id'],
                                    'quantity' => $this->dishItems[$key]['quantity'],
                                    'status_id' => 1,
                                    'update' => true
                                ]);
                            } else {
                                $dish_ni = FoodOrderDishKey::find($this->dishItems[$key]['id']);
                                $dish_ni->update([
                                    'order_id' => $this->orderId,
                                    'dish_id' => $this->dishItems[$key]['dish_id'],
                                    'quantity' => $this->dishItems[$key]['quantity'],
                                    'status_id' => 1,
                                    'update' => true
                                ]);
                            }
                        }

                        $billing = Billing::where('foodOrder_id', $this->orderId)->first();
                        if ($billing) {
                            $billing->update([
                                'total_amt' => $order_data['total_price'],
                            ]);

                            PaidAmount::create([
                                'billing_id' => $billing->id,
                                'payable_amt' => $order_data['total_price'],
                            ]);
                        } else {
                            // Create billing if it does not exist
                            $billed = Billing::create([
                                'customer_id' => $order->customer_id,
                                'foodOrder_id' => $order->id,
                                'total_amt' => $order_data['total_price'],
                                'status_id' => 6,
                            ]);

                            PaidAmount::create([
                                'billing_id' => $billed->id,
                                'payable_amt' => $order_data['total_price'],
                            ]);
                        }

                        // Move this outside the outer loop
                        foreach ($this->dishItems as $key => $value) {
                            FoodOrderDishKey::where('order_id', '=', $this->orderId)
                                ->update(['update' => 0]);
                        }

                        $action = "edit";
                        $message = 'Successfully Updated';
            } else {
                $order_data['status_id'] = 2;
                $order = FoodOrder::create($order_data);

                if (!$this->selectedCustomerId) {
                    $address_data['customer_id'] = $order->customer_id;
                } else {
                    $address_data['customer_id'] = $this->selectedCustomerId;
                }


                CustomerAddress::create($address_data);

                $currentYear = "ORD";
                $paddedRowId = str_pad($order->id, 6, '0', STR_PAD_LEFT);
                $result = $currentYear . $paddedRowId;

                $order->update([
                    'order_no' => $result
                ]);

                $bills = Billing::create([
                    'customer_id' => $order->customer_id,
                    'foodOrder_id' => $order->id,
                    'total_amt' => $order_data['total_price'],
                    // 'additional_amt' => $additionalAmt,
                    // 'advance_amt' => $advanceAmt,
                    // 'discount_amt' => $discountAmt,
                    'status_id' => 6,
                ]);

                PaidAmount::create([
                    'billing_id' => $bills->id,
                    'payable_amt' => $order_data['total_price'],
                ]);

                foreach ($this->dishItems as $key => $value) {
                    FoodOrderDishKey::create([
                        'order_id' => $order->id,
                        'dish_id' => $this->dishItems[$key]['dish_id'],
                        'quantity' => $this->dishItems[$key]['quantity'],
                        'status_id' => 1,
                        'update' => false
                    ]);
                }

                $action = "store";
                $message = 'Successfully Created';
            }

            FoodOrderDishKey::where('order_id', '=', $this->orderId)
                ->whereNotIn('dish_id', collect($this->dishItems)->pluck('dish_id')->toArray())
                ->delete();

            DB::commit();

            event(new OrderCreated($order));
            $this->emit('flashAction', $action, $message);
            $this->resetInputFields();
            $this->emit('closeFoodOrderModal');
            $this->emit('refreshParentFoodOrder');
            $this->emit('refreshTable');
        } catch (Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }

    public function calculatePrice()
    {
        $dishesTotalPrice = 0;
    
        foreach ($this->dishItems as $dishItem) {
            if (!empty($dishItem['dish_id'])) {
                $dish = Dish::find($dishItem['dish_id']);
    
                if ($dish) {
                    if ($dishItem['quantity'] == 0.5) {
                        $dishesTotalPrice += (float) $dish->price_half;
                    } else {
                        $dishesTotalPrice += (float) $dish->price_full * (int) $dishItem['quantity'];
                    }
                }
            }
        }
    
        $this->total_price = '₱ ' . number_format($dishesTotalPrice, 2);
    }
    

    public function addDish()
    {
        $this->dishItems[] = [
            'id' => null,
            'dish_id' => '',
            'quantity' => 1,
        ];
    }

    public function deleteDish($dishIndex)
    {
        unset($this->dishItems[$dishIndex]);
        $this->dishItems = array_values($this->dishItems);

        $this->calculatePrice();
    }

    public function render()
    {
        $customers = Customer::all();
        $transports = ModeOfTransportation::all();
        $dishes = Dish::all();

        if (strlen($this->searchQuery) > 0) {
            $this->customers = Customer::where('last_name', 'like', "%{$this->searchQuery}%")
                ->orWhere('first_name', 'like', "%{$this->searchQuery}%")
                ->orWhere('middle_name', 'like', "%{$this->searchQuery}%")
                ->get();
        }

        return view('livewire.food-order.food-order-form', compact('customers', 'dishes', 'transports'));
    }
}
