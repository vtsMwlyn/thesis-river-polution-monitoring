<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQuality extends Model
{
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // Filter by date + start & end time range if all are present
        $query->when(
            isset($filters['date'], $filters['starttime'], $filters['endtime']),
            function ($query) use ($filters) {
                return $query->whereBetween('date_and_time', [
                    $filters['date'] . ' ' . $filters['starttime'],
                    $filters['date'] . ' ' . $filters['endtime'],
                ]);
            }
        );

        // Else filter by just the date if only date is present
        $query->when(
            isset($filters['date']) && (!isset($filters['starttime']) || !isset($filters['endtime'])),
            function ($query) use ($filters) {
                return $query->where('date_and_time', 'like', $filters['date'] . '%');
            }
        );
    }
}
