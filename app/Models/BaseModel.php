<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const STATUS_COMMON_DELETED = -1;
    const STATUS_COMMON_OFFLINE = 0;
    const STATUS_COMMON_NORMAL = 1;

    const DEFAULT_PER_PAGE = 30;
}