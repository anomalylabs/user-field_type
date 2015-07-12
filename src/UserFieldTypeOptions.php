<?php namespace Anomaly\UserFieldType;

use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;

/**
 * Class UserFieldTypeOptions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UserFieldType
 */
class UserFieldTypeOptions
{

    /**
     * Handle the options.
     *
     * @param UserFieldType $fieldType
     */
    public function handle(UserFieldType $fieldType, RoleRepositoryInterface $roles)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        if ($role = array_get($fieldType->getConfig(), 'role')) {
            $query->join('users_users_roles', 'users_users_roles.entry_id', '=', 'users_users.id')
                ->where('users_users_roles.related_id', $role);
        }

        if (!$role && $permission = array_get($fieldType->getConfig(), 'permission')) {

            $accessible = $roles->findByPermission($permission);

            if (!$accessible->isEmpty()) {
                $query->join('users_users_roles', 'users_users_roles.entry_id', '=', 'users_users.id')
                    ->whereIn('users_users_roles.related_id', $accessible->lists('id'));
            }
        }

        $fieldType->setOptions(
            array_filter(
                [null => trans($fieldType->getPlaceholder())] +
                $query->get()->lists(
                    $model->getTitleName(),
                    $model->getKeyName()
                )
            )
        );
    }
}
