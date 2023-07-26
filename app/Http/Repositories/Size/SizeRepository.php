<?php
namespace App\Http\Repositories\Size;

use App\Models\Size;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\Size\SizeRepositoryInterface;

class SizeRepository implements SizeRepositoryInterface
{

    private $select_data = ['id', 'name','unit_type_id'];
    function list($request) {
        $sizes = Size::select($this->select_data)->get();
        return $sizes;
    }
    public function createOrUpdate($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $size = Size::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $size;
    }
    public function details($size)
    {
      return $size;
    }
}
