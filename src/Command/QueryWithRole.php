<?php namespace Anomaly\UserFieldType\Command;

use Anomaly\UserFieldType\UserFieldType;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class QueryWithRole
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UserFieldType\Command
 */
class QueryWithRole implements SelfHandling
{

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected $query;

    /**
     * The field type instance.
     *
     * @var UserFieldType
     */
    protected $fieldType;

    /**
     * Create a new QueryWithRole instance.
     *
     * @param UserFieldType $fieldType
     * @param Builder       $query
     */
    public function __construct(UserFieldType $fieldType, Builder $query)
    {
        $this->query     = $query;
        $this->fieldType = $fieldType;
    }

    /**
     * Handle the command.
     *
     * @param RoleRepositoryInterface $roles
     */
    public function handle(RoleRepositoryInterface $roles)
    {
        if ($role = array_get($this->fieldType->getConfig(), 'role')) {

            if (is_numeric($role)) {
                $role = $roles->find($role);
            }

            if (is_string($role)) {
                $role = $roles->findBySlug($role);
            }

            if ($role) {

                // The role exists so join and limit results to that role's ID.
                $this->query->join('users_users_roles', 'users_users_roles.entry_id', '=', 'users_users.id')
                    ->where('users_users_roles.related_id', $role->getId());
            } else {

                // The role doesn't exist so don't return anything.
                $this->query->join('users_users_roles', 'users_users_roles.entry_id', '=', 'users_users.id')
                    ->where('users_users_roles.related_id', false);
            }
        }
    }
}
