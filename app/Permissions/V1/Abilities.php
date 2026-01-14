<?php

namespace App\Permissions\V1;

use App\Models\User;

final class Abilities
{
    public const UpdateTicket = 'update:ticket';
    public const CreateTicket = 'create:ticket';
    public const ReplaceTicket = 'replace:ticket';
    public const DeleteTicket = 'delete:ticket';

    public const UpdateOwnTicket = 'ticket:own:update';
    public const DeleteOwnTicket = 'ticket:own:delete';

    public const CreateUser = 'user:create';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:replace';
    public const DeleteUser = 'user:delete';

    public static function getAbilities(User $user)
    {
        if ($user->is_manager) {
            return [
                self::CreateTicket,
                self::UpdateTicket,
                self::ReplaceTicket,
                self::DeleteTicket,
                self::CreateUser,
                self::UpdateUser,
                self::ReplaceUser,
                self::DeleteUser,
            ];
        } else {
            return [
                self::CreateTicket,
                self::UpdateOwnTicket,
                self::DeleteOwnTicket,
            ];
        }
    }
}
