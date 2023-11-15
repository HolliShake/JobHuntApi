<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ControllerBase extends Controller {

    /**
     * Ok - 200
     * Returns a 200 response with the data
     */
    function ok($data) {
        return response()->json($data, 200);
    }

    /**
     * Created - 201
     * Returns a 201 response with the data
     */

    function created($data) {
        return response()->json($data, 201);
    }

    /**
     * No Content - 201
     * Returns a 204 response without data
     */
    function noContent() {
        return response('', 204);
    }

    /**
     * Bad Request - 400
     * Returns a 400 response with the error message
     */
    function badRequest($data) {
        return response()->json($data, 400);
    }

    /**
     * Unauthorized - 401
     * Returns a 401 response with the error message
     */
    function unauthorized($message) {
        return response()->json(['message' => $message], 401);
    }

    /**
     * Forbidden - 403
     * Returns a 403 response with the error message
     */
    function forbidden($message) {
        return response()->json(['message' => $message], 403);
    }

    /**
     * Not Found - 404
     * Returns a 404 response with the error message
     */
    function notFound($message) {
        return response()->json(['message' => $message], 404);
    }
}

