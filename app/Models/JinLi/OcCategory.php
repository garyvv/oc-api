<?php
namespace App\Models\JinLi;


use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class OcCategory extends BaseModel
{
    protected $table = 'oc_category';
    protected $primaryKey = 'category_id';

    public static function getTabbarCategories()
    {
        return DB::table('oc_category AS c')
            ->leftJoin('oc_category_description AS cd', 'c.category_id', '=', 'cd.category_id')
            ->select(
                'c.category_id',
                DB::raw('CONCAT("' . env('TOY_HTTP_IMAGE') . '", c.image) AS image'),
                'cd.name'
            )
            ->where([
                'status' => self::STATUS_COMMON_NORMAL,
                'parent_id' => 0
            ])
            ->orderBy('sort_order', 'ASC')
            ->get();
    }
}