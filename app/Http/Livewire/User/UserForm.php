<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads;
    public $userId, $first_name, $middle_name, $last_name, $username, $email, $password, $password_confirmation;
    public $photo;
    public $action = '';  //flash
    public $message = '';  //flash
    public $roleCheck = array();
    public $selectedRoles = [];
    public $photoPath;

    protected $listeners = [
        'userId',
        'resetInputFields',
        'updatePhotoPreview'
    ];

    public function updatedPhoto($photo)
    {
        $this->validate([
            'photo' => 'image|max:1024', // Example validation rule for image size
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

    //edit
    public function userId($userId)
    {
        $this->userId = $userId;
        $user = User::find($userId);
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->photo = $user->photo;

        $this->selectedRoles = $user->getRoleNames()->toArray();
    }

    //store
    // public function store()
    // {
    //     try {
    //         DB::beginTransaction();

    //         if (is_object($this->selectedRoles)) {
    //             $this->selectedRoles = json_decode(json_encode($this->selectedRoles), true);
    //         }

    //         if (empty($this->roleCheck)) {
    //             $this->roleCheck = array_map('strval', $this->selectedRoles);
    //         }

    //         $validationRules = [
    //             'first_name' => 'required',
    //             'middle_name' => 'nullable',
    //             'last_name' => 'required',
    //             'username' => 'required',
    //             'email' => ['required', 'email'],
    //         ];

    //         if ($this->photo) {
    //             // $file = $this->photo->store('photo');
    //             // $filename = date('YmdHi').$file->getClientOriginalName();
    //             // $file->move(public_path('upload/images'),$filename);
    //             // $filename = date('YmdHi') . '_' . $this->photo->getClientOriginalName();
    //             // $this->photo->move(public_path('upload/images'), $filename);
    //             $file = $this->photo->storeAs('upload/images', $this->photo->getClientOriginalName());
    //         }
    //         // If it's an update, only validate the password if it's provided
    //         if ($this->userId) {
    //             $validationRules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
    //         } else {
    //             // For a new user, require password
    //             $validationRules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
    //         }

    //         $this->validate($validationRules);

    //         if ($this->userId) {
    //             $data = [
    //                 'first_name' => $this->first_name,
    //                 'middle_name' => $this->middle_name,
    //                 'last_name' => $this->last_name,
    //                 'username' => $this->username,
    //                 'email' => $this->email,
    //             ];

    //             $user = User::find($this->userId);
    //             $user->update($data);

    //             if (!empty($this->password)) {
    //                 $this->validate([
    //                     'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
    //                 ]);

    //                 $user->update([
    //                     'password' => Hash::make($this->password),
    //                 ]);
    //             }

    //             $user->update([
    //                 'photo' => $filename,
    //             ]);

    //             if ($this->photo && $user->photo) {
    //                 Storage::disk('public')->delete('photos/' . $user->photo);
    //             }
    //             // Update roles
    //             $user->syncRoles($this->roleCheck);

    //             $action = 'edit';
    //             $message = 'Successfully Updated';
    //         } else {
    //             // For a new user
    //             $user = User::create([
    //                 'first_name' => $this->first_name,
    //                 'middle_name' => $this->middle_name,
    //                 'last_name' => $this->last_name,
    //                 'username' => $this->username,
    //                 'email' => $this->email,
    //                 'password' => Hash::make($this->password),
    //                 'photo' => $filename,
    //             ]);

    //             // Assign roles
    //             $user->assignRole($this->roleCheck);

    //             $action = 'store';
    //             $message = 'Successfully Created';
    //         }

    //         DB::commit();

    //         $this->emit('flashAction', $action, $message);
    //         $this->resetInputFields();
    //         $this->emit('closeUserModal');
    //         $this->emit('refreshParentUser');
    //         $this->emit('refreshTable');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         $this->emit('flashAction', 'error', 'Error: ' . $e->getMessage());
    //     }
    // }

    public function store()
    {
        try {
            DB::beginTransaction();

            // Validate input fields
            $validationRules = [
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'username' => 'required',
                'email' => ['required', 'email'],
            ];

            // If it's an update, only validate the password if it's provided
            if ($this->userId) {
                $validationRules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
            } else {
                // For a new user, require password
                $validationRules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
            }

            $this->validate($validationRules);

            // Handle photo upload
            $filename = null;
            if ($this->photo) {
                $user = $this->userId ? User::find($this->userId) : null;

                if ($user && $user->photo) {
                    Storage::delete('public/images/' . $user->photo);
                }

                $filename = date('YmdHi') . '_' . $this->photo->getClientOriginalName();
                $this->photo->storeAs('public/images', $filename);
            }

            // Update or create user
            $userData = [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'username' => $this->username,
                'email' => $this->email,
                'photo' => $filename,
            ];

            if ($this->userId) {
                // Update existing user
                $user = User::findOrFail($this->userId);
                $user->update($userData);
            } else {
                // Create new user
                $userData['password'] = Hash::make($this->password);
                $user = User::create($userData);
            }

            // Sync roles
            if (!empty($this->roleCheck)) {
                $user->syncRoles($this->roleCheck);
            }

            DB::commit();

            // Flash success message
            $this->emit('flashAction', $this->userId ? 'edit' : 'store', 'Successfully ' . ($this->userId ? 'Updated' : 'Created'));

            // Reset input fields and close modal
            $this->resetInputFields();
            $this->emit('closeUserModal');
            $this->emit('refreshParentUser');
            $this->emit('refreshTable');
        } catch (\Exception $e) {
            // Roll back database transaction and flash error message
            DB::rollBack();
            $this->emit('flashAction', 'error', 'Error: ' . $e->getMessage());
        }
    }


    public function render()
    {
        $roles = Role::all();
        return view('livewire.user.user-form', [
            'roles' => $roles,
        ]);
    }
}
