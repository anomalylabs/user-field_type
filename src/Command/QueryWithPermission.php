<?php namespace Anomaly\UserFieldType\Command;

use Anomaly\UserFieldType\UserFieldType;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class QueryWithPermission
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UserFieldType\Command
 */
class QueryWithPermission implements SelfHandling
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
     * Create a new QueryWithPermission instance.
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
        if (!$this->query->getQuery()->joins && $permission = array_get($this->fieldType->getConfig(), 'permission')) {

            $accessible = $roles->findByPermission($permission);

            if (!$accessible->isEmpty()) {
                $this->query->join('users_users_roles', 'users_users_roles.entry_id', '=', 'users_users.id')
                    ->whereIn('users_users_roles.related_id', $accessible->lists('id'));
            }
        }
    }
}
