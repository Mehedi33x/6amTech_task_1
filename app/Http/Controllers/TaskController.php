<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DataHandleService;

class TaskController extends Controller
{
    protected $dataService;
    public function __construct(DataHandleService $dataService)
    {
        $this->dataService = $dataService;
    }
    public function index()
    {
        $tasks = auth()->user()->tasks()->select('id', 'title', 'description', 'status')->latest()->get();
        return response()->json(['success' => true, 'data' => $tasks]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $task = $this->dataService->store(new Task(), [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'message' => 'Task created', 'data' => $task], 201);
    }
    public function show($id)
    {
        // dd($id);
        $task = auth()->user()->tasks()->with('user:id,name')->find($id);
        if (!$task) {
            return response()->json(['success' => false, 'message' => 'No task found'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $task->id,
                'user_name' => $task->user->name,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
            ]
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd(auth()->user()->tasks()->get());
        $task = auth()->user()->tasks()->find($id);
        if (!$task) {
            return response()->json(['success' => false, 'message' => 'No task found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,in_progress,completed'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $this->dataService->update($task, $request->only(['title', 'description', 'status']));
        return response()->json(['success' => true, 'message' => 'Task updated', 'data' => $task]);
    }
    public function destroy($id)
    {
        $task = auth()->user()->tasks()->find($id);
        if (!$task) {
            return response()->json(['success' => false, 'message' => 'No task found'], 404);
        }
        $task->delete();
        return response()->json(['success' => true, 'message' => 'Task deleted']);
    }
}

