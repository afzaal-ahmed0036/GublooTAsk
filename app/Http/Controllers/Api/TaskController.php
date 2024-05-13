<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends ApiResponseController
{
    public function index()
    {
        try {
            $tasks = Task::orderBy("created_at", "desc")->paginate(10);
            return $this->sendSuccess($tasks, 'Data Feteched');
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error' => $e->getMessage()]);
        }

    }
    public function searchTask(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'text' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $tasks = Task::where("title", "LIKE", "%" . $request->text . "%")->orWhere("description", "LIKE", "%" . $request->text . "%")->get();
            if (count($tasks) > 0) {
                return $this->sendSuccess($tasks, 'Data Feteched');
            } else {
                return $this->sendSuccess('No Data Found', '0 records found');
            }
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error' => $e->getMessage()]);
        }
    }
    public function attachTaskCategory(Request $request)
    {
        try {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'task_id' => 'required',
                'category_id' => 'required|array'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $task = Task::findOrFail($request->task_id);
            $task->categories()->attach($request->category_id);
            $success['task'] = $task;
            $success['categories'] = $task->categories;
            return $this->sendSuccess($success, 'Attached Successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error' => $e->getMessage()]);
        }
    }
}
