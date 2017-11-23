<?php

namespace App\Console\Commands\JinLi;

use App\Libraries\CacheKey;
use App\Models\JinLi\ToyUserView;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserViewHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Toy:UserViewHistory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用户浏览足迹记录入库';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        //
        $cacheKey = CacheKey::USER_VIEW_HISTORY;

        $insert = false;
        $sql = 'INSERT INTO `toy_user_views` (`uid`, `product_id`, `view_time`, `created_at`) VALUES ';

        $now = date('Y-m-d H:i:s');

        while (!empty($data = json_decode(Redis::lpop($cacheKey), true)))
        {
            $insert = true;

            if (!isset($data['uid']) || empty($data['uid'])) {
                \Log::error('--- uid 不存在或为空');
                continue;
            }

            if (!isset($data['product_id']) || empty($data['product_id'])) {
                \Log::error('--- product_id 不存在或为空');
                continue;
            }

            $data['view_time'] = isset($data['view_time']) ? $data['view_time'] : $now;

            $insertData[] = $data;
            $sql .= '(' . $data['uid'] . ', ' . $data['product_id'] . ', "' . $data['view_time'] . '", "' . $now . '"),';
        }

        if($insert === true) {
            $sql = rtrim($sql, ',');

            $sql .= "ON DUPLICATE KEY UPDATE view_time = VALUES(view_time); ";

            DB::insert($sql);
        }

    }

}
