<?php

namespace App\Traits;

trait WithDynamicFilters
{
    protected function applyFilters($query, array $filters, array $filterConfig)
    {
        foreach ($filters as $field => $value) {
            if (!isset($value) || $value === '') {
                continue;
            }

            $config = $filterConfig[$field] ?? null;
            if (!$config) {
                continue;
            }

            $type = $config['type'] ?? 'exact';

            switch ($type) {
                case 'like':
                    $query->where($field, 'like', '%' . $value . '%');
                    break;

                case 'date_range':
                    $dates = explode(' to ', $value);
                    if (count($dates) == 2) {
                        $query->whereBetween($field, [
                            $dates[0] . ' 00:00:00',
                            $dates[1] . ' 23:59:59'
                        ]);
                    }
                    break;

                case 'relationship':
                    $relation = $config['relation'] ?? $field;
                    $query->whereHas($relation, function($q) use ($value, $config) {
                        $q->where($config['field'] ?? 'id', $value);
                    });
                    break;

                case 'exact':
                default:
                    $query->where($field, $value);
                    break;
            }
        }

        return $query;
    }
}
