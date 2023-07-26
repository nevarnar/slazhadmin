<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\SizeGuide;
use App\Models\SizeChartRegion;

class SizeChart extends Model
{
    protected $fillable = [
        'size_guide_id',
        'size_chart_region_id',
        'chart_table'
    ];

    public function sizeChartRegion()
    {
        return $this->belongsTo(SizeChartRegion::class);
    }

    public function sizeGuides()
    {
        return $this->belongsToMany(SizeGuide::class, 'size_guide_size_chart', 'size_chart_id', 'size_guide_id');
    }
}
