<?php

namespace KraenkVisuell\NovaSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as BaseCollection;
use KraenkVisuell\NovaSettings\NovaSettings;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasTranslations;

    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;
    public $fillable = ['key', 'value'];

    public $translatable = [
        'value',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(NovaSettings::getSettingsTableName());
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getValueAttribute($value)
    {
        $originalCasts = $this->casts;
        $this->casts = NovaSettings::getCasts();

        if ($this->hasCast($this->key)) {
            $value = $this->castAttribute($this->key, $value);
        }

        $this->casts = $originalCasts;

        return $value;
    }

    public static function getValueForKey($key)
    {
        $setting = static::where('key', $key)->get()->first();

        return isset($setting) ? $setting->value : null;
    }
}
