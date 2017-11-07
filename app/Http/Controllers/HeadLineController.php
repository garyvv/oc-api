<?php
/**
 * User: linjianmin
 * Date: 2017/10/27
 * Time: 15:50
 */

namespace App\Http\Controllers;


use App\Services\HeadLineService;
use Illuminate\Support\Facades\Input;

class HeadLineController extends Controller
{
    public function index()
    {
        $limit = Input::get('limit', 8);
        $headLineService = new HeadLineService();
        $headLines = $headLineService->getHeadLines($limit);
        return $this->respData($headLines);
    }
}