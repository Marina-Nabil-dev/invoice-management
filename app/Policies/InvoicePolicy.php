<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasPermissionTo('viewAnyInvoice');
    }

    public function view(User $user, Invoice $invoice) {
        return $user->hasPermissionTo('viewInvoice');
    }

    public function create(User $user) {
        return $user->hasPermissionTo('createInvoice');
    }

    public function update(User $user, Invoice $invoice) {
        return $user->hasPermissionTo('updateInvoice');
    }

    public function delete(User $user, Invoice $invoice) {
        return $user->hasPermissionTo('deleteInvoice');
    }

    public function restore(User $user, Invoice $invoice) {
        return $user->hasPermissionTo('restoreInvoice');
    }

    public function forceDelete(User $user, Invoice $invoice) {
        return $user->hasPermissionTo('forceDeleteInvoice');
    }
}
