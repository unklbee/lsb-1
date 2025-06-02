<?php
// app/Models/SettingModel.php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'key', 'value', 'type', 'group', 'label', 'description'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getByKey($key)
    {
        $setting = $this->where('key', $key)->first();
        if (!$setting) return null;

        return $this->parseValue($setting['value'], $setting['type']);
    }

    public function getByGroup($group): array
    {
        $settings = $this->where('group', $group)->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['key']] = $this->parseValue($setting['value'], $setting['type']);
        }

        return $result;
    }

    public function getAllSettings(): array
    {
        $settings = $this->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['key']] = $this->parseValue($setting['value'], $setting['type']);
        }

        return $result;
    }

    public function updateSetting($key, $value): bool
    {
        $setting = $this->where('key', $key)->first();
        if (!$setting) return false;

        $formattedValue = $this->formatValue($value, $setting['type']);
        return $this->update($setting['id'], ['value' => $formattedValue]);
    }

    private function parseValue($value, $type)
    {
        switch ($type) {
            case 'json':
                return json_decode($value, true);
            case 'boolean':
                return (bool) $value;
            case 'number':
                return is_numeric($value) ? (float) $value : $value;
            default:
                return $value;
        }
    }

    private function formatValue($value, $type)
    {
        switch ($type) {
            case 'json':
                return json_encode($value);
            case 'boolean':
                return $value ? '1' : '0';
            default:
                return (string) $value;
        }
    }
}
