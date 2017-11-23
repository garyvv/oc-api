<?php
namespace App\Models\JinLi;


use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class ToyUserView extends BaseModel
{
    public static function getUserViewHistory($uid)
    {
        return DB::table('toy_user_views AS v')
            ->leftJoin('oc_product AS p', 'v.product_id', 'p.product_id')
            ->select(
                'p.product_id',
                'p.price',
                'p.viewed',
                'p.image',
                'p.title',
//                'p.content',
                'v.view_time'
            )
            ->where('v.uid', $uid)
            ->orderBy('v.view_time', 'desc')
            ->limit(self::DEFAULT_PER_PAGE)
            ->get();
    }
}