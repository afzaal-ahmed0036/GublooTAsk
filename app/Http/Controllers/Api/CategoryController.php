<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiResponseController
{
    public function invoke()
    {
        try {
            $categories = Category::orderBy('priority')->get();
            return $this->sendSuccess($categories, count($categories) . ' Records found.');
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error' => $e->getMessage()]);
        }

    }
}
