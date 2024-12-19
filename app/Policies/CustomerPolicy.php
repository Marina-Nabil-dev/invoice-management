<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) {
       return $user->hasPermissionTo('viewAnyCustomer');
    }

    public function view(User $user, Customer $customer) {
        return $user->hasPermissionTo('viewCustomer');
    }

    public function create(User $user) {
        return $user->hasPermissionTo('createCustomer');
    }

    public function update(User $user, Customer $customer) {
        return $user->hasPermissionTo('updateCustomer');
    }

    public function delete(User $user, Customer $customer) {
        return $user->hasPermissionTo('deleteCustomer');
    }

    public function restore(User $user, Customer $customer) {
        return $user->hasPermissionTo('restoreCustomer');
    }

    public function forceDelete(User $user, Customer $customer) {
        return $user->hasPermissionTo('forceDeleteCustomer');
    }
}
