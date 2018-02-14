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

    /***
     *
     * @param $content
     * @param int $status_code
     * @param array $headers
     * @return \Illuminate\Http\Response
     */
    public function response($content, int $status_code = 200, $headers = []) {
        return Response::create($content,$status_code,$headers);
    }

    /***
     * Opens a Database transaction.
     */
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    /***
     * Rollback and close a Database transaction.
     */
    public function rollback()
    {
        DB::rollback();
    }

    /***
     * Commit a Database transaction.
     */
    public function commit()
    {
        DB::commit();
    }
}
