<?php namespace Anomaly\UserFieldType;

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
     * @return array
     */
    public function handle(UserFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        return [null => trans($fieldType->getPlaceholder())] +
        $query->get()->lists(
            array_get($fieldType->getConfig(), 'title', $model->getTitleName()),
            array_get($fieldType->getConfig(), 'key', $model->getKeyName())
        );
    }
}
