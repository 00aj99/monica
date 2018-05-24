<?php

namespace App\Models\Settings\CustomFields;

use App\Account;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\CustomFields\Field;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Settings\CustomFields\CustomFieldPattern;

class CustomField extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $table = 'custom_fields';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_list' => 'boolean',
        'is_important' => 'boolean',
    ];

    /**
     * Get the account record associated with the custom field.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the custom field pattern record associated with the custom field.
     *
     * @return BelongsTo
     */
    public function customFieldPattern()
    {
        return $this->belongsTo(CustomFieldPattern::class);
    }

    /**
     * Get the field records associated with the custom field.
     *
     * @return HasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    /**
     * Get the name of the custom field.
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return $value;
    }

    /**
     * Indicate the order of the fields for this custom field.
     *
     * @return bool
     */
    public function getFieldsOrderAttribute($value)
    {
        return $value;
    }

    /**
     * Indicate wether the custom field is a single item, or a list of items.
     *
     * @return bool
     */
    public function getIsListAttribute($value)
    {
        return $value;
    }

    /**
     * Indicate wether the custom field is important or not.
     * This will decide the placement of the field on the contact sheet.
     *
     * @return bool
     */
    public function getIsImportantAttribute($value)
    {
        return $value;
    }
}
