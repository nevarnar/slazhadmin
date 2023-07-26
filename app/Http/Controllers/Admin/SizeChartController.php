<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\SizeChartRegion;
use App\Models\SizeChart;
use App\Models\SizeGuide;

class SizeChartController extends Controller{

    public function getSizeChartRegions()
    {
        $size_chart_regions = SizeChartRegion::all();

        responseData('regions', $size_chart_regions, 200);
    }

    public function createSizeChart(Request $request)
    {
        $size_chart_region = SizeChartRegion::find($request["size_chart_region_id"]);
        $size_chart = SizeChart::create($request->all());

        $data = [
            "size_chart_region_id"=> $size_chart_region->id,
            "size_chart_region_name"=> $size_chart_region->name,
            "size_chart_id"=> $size_chart->id,
            "chart_table" => $size_chart->chart_table
        ];

        responseData("size_chart",$data,200);
    }

    public function updateSizeChart(Request $request)
    {
        $size_chart = SizeChart::find($request["size_chart_id"]);
        $size_chart->chart_table = $request["chart_table"];
        $size_chart->save();

        $data = [
            "size_chart_region_id"=> $size_chart->sizeChartRegion->id,
            "size_chart_region_name"=> $size_chart->sizeChartRegion->name,
            "size_chart_id"=> $size_chart->id,
            "chart_table" => $size_chart->chart_table
        ];

        responseData("size_chart",$data,200);
    }

    public function deleteSizeChart(Request $request)
    {
        SizeChart::destroy($request["size_chart_id"]);

        responseTrue("OK");
    }

    public function getSizeGuides()
    {
        $size_guides = SizeGuide::all();

        responseData("size_guides", $size_guides, 200);
    }

    public function createSizeGuide(Request $request)
    {
        if ($request->has("size_guide_id")) {
            $size_guide = SizeGuide::find($request["size_guide_id"]);
            $size_guide->name = $request["size_guide_name"];
            $size_guide->save();
            $size_charts = json_decode($request["size_chart_ids"], true);
            foreach($size_charts as $size_chart){
                $size_guide->sizeCharts()->detach($size_chart["size_chart_id"]);
                $size_guide->sizeCharts()->attach($size_chart["size_chart_id"]);
            }
        } else {
            $size_guide = SizeGuide::create([
                "name" => $request["size_guide_name"]
            ]);

            $size_charts = json_decode($request["size_chart_ids"], true);
            foreach($size_charts as $size_chart){
                $size_guide->sizeCharts()->detach($size_chart["size_chart_id"]);
                $size_guide->sizeCharts()->attach($size_chart["size_chart_id"]);
            }
        }


        responseTrue("OK");
    }

    public function deleteSizeGuide(Request $request)
    {
        SizeGuide::destroy($request["size_guide_id"]);

        responseTrue("OK");
    }

    public function updateSizeGuide(SizeGuide $size_guide)
    {
        return view('sizeguide.create', [
            "size_guide" => $size_guide
        ]);
    }

    public function getSizeCharts(Request $request)
    {
        $size_guide = SizeGuide::find($request["size_guide_id"]);
        $charts = [];
        $size_charts = $size_guide->sizeCharts;
        foreach($size_charts as $chart){
            $data = [
                "size_chart_region_id" => $chart->sizeChartRegion->id,
                "size_chart_region_name" => $chart->sizeChartRegion->name,
                "size_chart_id" => $chart->id,
                "chart_table" => $chart->chart_table
            ];
            array_push($charts, $data);
        }

        responseData("charts", $charts, 200);
    }
}
