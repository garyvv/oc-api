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
            ->leftJoin('oc_product_image AS pi', 'pi.product_id', '=', 'p2c.product_id')
            ->select(
                'p.product_id',
                'p.price',
                'p.viewed',
                'p.image',
                DB::raw('GROUP_CONCAT(pi.image) AS photos'),
                'p.model',
                'p.content AS description'
            )
            ->where([
                'p.status' => self::STATUS_COMMON_NORMAL,
                'p2c.category_id' => $categoryId
            ])
            ->orderBy('p.sort_order', 'ASC')
            ->groupBy('p2c.product_id')
            ->paginate(self::DEFAULT_PER_PAGE);
    }


    public static function getProduct($productId)
    {
        return DB::table('oc_product AS p')
            ->leftJoin('oc_product_to_category AS p2c', 'p2c.product_id', '=', 'p.product_id')
            ->leftJoin('oc_category AS c', 'c.category_id', '=', 'p2c.category_id')
            ->leftJoin('oc_product_image AS pi', 'pi.product_id', '=', 'p.product_id')
            ->select(
                'p.product_id',
                'p.price',
                'p.viewed',
                'p.image',
                'p.model',
                'p.content AS description',
                DB::raw('GROUP_CONCAT(c.name) AS category'),
                DB::raw('GROUP_CONCAT(c.category_id) AS category_ids'),
                DB::raw('GROUP_CONCAT(pi.image ORDER BY pi.sort_order ASC) AS images')
            )
            ->where([
                'p.status' => self::STATUS_COMMON_NORMAL,
                'p.product_id' => $productId
            ])
            ->groupBy('p.product_id')
            ->first();
    }
}