<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($content, int $status_code = 200, $headers = []) {
        return Response::create($content,$status_code,$headers);
    }

    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    public function rollback()
    {
        DB::rollback();
    }

    public function commit()
    {
        DB::commit();
    }
}
