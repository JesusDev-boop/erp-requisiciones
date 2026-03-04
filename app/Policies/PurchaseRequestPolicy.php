<?php

namespace App\Policies;

use App\Models\PurchaseRequest;
use App\Models\User;

class PurchaseRequestPolicy
{
    /**
     * Ver listado
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            'coordinador',
            'compras',
            'administrador'
        ]);
    }

    /**
     * Ver una requisición específica
     */
    public function view(User $user, PurchaseRequest $request): bool
    {
        return in_array($user->role, [
            'coordinador',
            'compras',
            'administrador'
        ]);
    }

    /**
     * Crear requisición
     * SOLO Coordinador
     */
    public function create(User $user): bool
    {
        return $user->role === 'coordinador';
    }

    /**
     * Editar requisición
     * - Administrador puede siempre
     * - Coordinador solo si está en borrador
     */
    public function update(User $user, PurchaseRequest $request): bool
    {
        if ($user->role === 'administrador') {
            return true;
        }

        if (
            $user->role === 'coordinador' &&
            $request->estatus === 'borrador'
        ) {
            return true;
        }

        return false;
    }

    /**
     * Cambiar estatus
     */
  public function changeStatus(User $user, PurchaseRequest $purchaseRequest)
{
    // Administrador puede todo
    if ($user->role === 'administrador') {
        return true;
    }

    // Compras puede cambiar cualquier estatus
    if ($user->role === 'compras') {
        return true;
    }

    // Coordinador solo puede cambiar su propia requisición
    if ($user->role === 'coordinador') {

        if ($purchaseRequest->user_id !== $user->id) {
            return false;
        }

        return in_array($purchaseRequest->estatus, [
            'borrador',
            'devuelta'
        ]);
    }

    return false;
}
    /**
     * Eliminar (bloqueado por ahora)
     */
public function delete(User $user, PurchaseRequest $request): bool
{
    // No permitir eliminar canceladas (opcional)
    if ($request->estatus === 'cancelada') {
        return false;
    }

    // Administrador puede siempre
    if ($user->role === 'administrador') {
        return true;
    }

    // Compras puede eliminar
    if ($user->role === 'compras') {
        return true;
    }

    // Coordinador solo si es suya
    if (
        $user->role === 'coordinador' &&
        $request->user_id === $user->id
    ) {
        return true;
    }

    return false;
}

    public function restore(User $user, PurchaseRequest $request): bool
    {
        return false;
    }

    public function forceDelete(User $user, PurchaseRequest $request): bool
    {
        return false;
    }
}