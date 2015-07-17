<?php namespace Anomaly\UserFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\UsersModule\User\Contract\UserInterface;

/**
 * Class UserFieldTypeModifier
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UserFieldType
 */
class UserFieldTypeModifier extends FieldTypeModifier
{

    /**
     * The field type instance.
     * This is for IDE support.
     *
     * @var UserFieldType
     */
    protected $fieldType;

    /**
     * Modify the value.
     *
     * @param $value
     * @return int
     */
    public function modify($value)
    {
        if ($value instanceof UserInterface) {
            return $value->getId();
        }

        return $value;
    }

    /**
     * Restore the value.
     *
     * @param $value
     * @return null|EloquentModel
     */
    public function restore($value)
    {
        if (is_numeric($value)) {

            $relation = $this->fieldType->getRelatedModel();

            return $relation->find($value);
        }

        return $value;
    }
}
