<?php namespace Anomaly\UserFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\UserFieldType\Command\BuildOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UserFieldType
 */
class UserFieldType extends FieldType
{

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.user::input';

    /**
     * The filter view.
     *
     * @var string
     */
    protected $filterView = 'anomaly.field_type.user::filter';

    /**
     * The field type config.
     *
     * @var array
     */
    protected $config = [
        'handler' => 'Anomaly\UserFieldType\UserFieldTypeOptions@handle'
    ];

    /**
     * The dropdown options.
     *
     * @var null|array
     */
    protected $options = null;

    /**
     * Get the relation.
     *
     * @return BelongsTo
     */
    public function getRelation()
    {
        $entry = $this->getEntry();

        return $entry->belongsTo('Anomaly\UsersModule\User\UserModel', $this->getColumnName());
    }

    /**
     * Get the related model.
     *
     * @return EloquentModel
     */
    public function getRelatedModel()
    {
        return app()->make('Anomaly\UsersModule\User\UserModel');
    }

    /**
     * Get the dropdown options.
     *
     * @return array
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->dispatch(new BuildOptions($this));
        }

        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the placeholder.
     *
     * @return null|string
     */
    public function getPlaceholder()
    {
        return $this->placeholder ?: 'anomaly.field_type.user::input.placeholder';
    }

    /**
     * Get the database column name.
     *
     * @return null|string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }
}
