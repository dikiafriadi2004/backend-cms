<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group'
    ];

    protected $casts = [
        // Remove JSON casting since the field is already JSON in database
        // and we want to handle the casting manually based on type
    ];

    public function getValueAttribute($value)
    {
        // Decode JSON value from database
        $decoded = json_decode($value, true);
        
        // Handle different types
        switch ($this->type) {
            case 'boolean':
                return (bool) $decoded;
            case 'integer':
                return (int) $decoded;
            case 'array':
                return is_array($decoded) ? $decoded : [];
            default:
                return $decoded;
        }
    }

    public function setValueAttribute($value)
    {
        // Encode value as JSON for storage
        $this->attributes['value'] = json_encode($value);
    }

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]
        );
    }

    public static function getGroup($group)
    {
        return static::where('group', $group)->pluck('value', 'key');
    }
}