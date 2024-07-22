<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function checkBelongsToTenant($site, $model)
    {
        if ($site->id !== $model->site_id) {
            abort(404);
        }
    }

    public function message($message, $status = 200)
    {
        return response()->json(['message' => $message], $status);
    }

    public function success($message, $status = 200)
    {
        return response()->json(['message' => $message], $status);
    }

    public function data($data, $status = 200)
    {
        return response()->json(['data' => $data], $status);
    }

    public function response($data, $message, $status = 200)
    {
        return response()->json(['data' => $data, 'message' => $message], $status);
    }

    public function json($responseBody, $status = 200)
    {
        return response()->json($responseBody, $status);
    }
}
