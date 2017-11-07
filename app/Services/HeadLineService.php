<?php
/**
 * User: linjianmin
 * Date: 2017/10/27
 * Time: 17:14
 */
namespace App\Services;

use App\Models\HeadLineModel;

class HeadLineService extends BaseService
{
    public function getHeadLines($limit = 8)
    {
        $headLineModel = new HeadLineModel();
        $headLines = $headLineModel->select('id','title','link','thumb','type', 'author')->where('status', 1)->paginate($limit);
        return $headLines;
    }


}