<?php
namespace App\Models\JinLi;


use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class OcProduct extends BaseModel
{
    protected $table = 'oc_product';
    protected $primaryKey = 'product_id';

    public static function getProductsByCategoryId($categoryId)
    {
        return DB::table('oc_product_to_category AS p2c')
            ->leftJoin('oc_product AS p', 'p2c.product_id', '=', 'p.product_id')
            ->select(
                'p.product_id',
                'p.price',
                'p.viewed',
//                DB::raw('CONCAT("' . env('TOY_HTTP_IMAGE') . '", p.image) AS image'), // todo
                DB::raw('"/images/common/index-toy.png" AS image'),
                'p.model',
                DB::raw('CONCAT("详细信息: ", model) AS description')
            )
            ->where([
                'p.status' => self::STATUS_COMMON_NORMAL,
                'p2c.category_id' => $categoryId
            ])
            ->orderBy('sort_order', 'ASC')
            ->paginate(self::DEFAULT_PER_PAGE);
    }

}