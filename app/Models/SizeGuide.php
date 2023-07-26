<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SizeChart;

class SizeGuide extends Model
{
    protected $fillable = [
        'product_id',
        'name'
    ];

    public function sizeCharts()
    {
        return $this->belongsToMany(SizeChart::class, 'size_guide_size_chart', 'size_guide_id', 'size_chart_id');
    }
}
