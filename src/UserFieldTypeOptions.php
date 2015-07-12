<?php namespace Anomaly\UserFieldType;

use Anomaly\UserFieldType\Command\QueryWithPermission;
use Anomaly\UserFieldType\Command\QueryWithRole;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * Handle the options.
     *
     * @param UserFieldType $fieldType
     */
    public function handle(UserFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        $this->dispatch(new QueryWithRole($fieldType, $query));
        $this->dispatch(new QueryWithPermission($fieldType, $query));

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
