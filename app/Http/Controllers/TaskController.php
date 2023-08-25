<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{  
    public function __construct()
    {
    }

    public function home()
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        $completed_count = $tasks
            ->where('status', Task::STATUS_COMPLETED)
            ->count();

        $uncompleted_count = $tasks
            ->whereNotIn('status', Task::STATUS_COMPLETED)
            ->count();

        return view('home', [
            'completed_count' => $completed_count,
            'uncompleted_count' => $uncompleted_count,
        ]);
    }

    public function index()
    {
        $pageTitle = 'Task List';
        $tasks = Task::all(); // Diperbarui
        return view('tasks.index', [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks,
        ]);
    }

    public function create($status = NULL)
    {
        $pageTitle = 'Create Task';

        return view('tasks.create', ['pageTitle' => $pageTitle, 'status' => $status]);
    }

    public function store(Request $request)
    {
        // Code untuk proses validasi
        $request->validate(
            [
                'name' => 'required',
                'due_date' => 'required',
                'status' => 'required',
            ],
            $request->all()
        );
        Task::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('tasks.index');
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Task';
        $task = Task::find($id); // Diperbarui

        Gate::authorize('update', $task);

        return view('tasks.edit', ['pageTitle' => $pageTitle, 'task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        Gate::authorize('update', $task);

        $task->update([
            // data task yang berasal dari formulir
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->duedate,
            'status' => $request->status
        ]);

        // Code untuk melakukan redirect menuju GET /tasks
        return redirect()->route('tasks.index');
    }

    public function delete($id)
    {
        // Menyebutkan judul dari halaman yaitu "Delete Task"   
        $pageTitle = 'Delete Task'; 
        //  Memperoleh data task menggunakan $id
        $task = Task::find($id);   
        
        Gate::authorize('delete', $task);
        // Menghasilkan nilai return berupa file view dengan halaman dan data task di atas 
        return view('tasks.delete', ['pageTitle' => $pageTitle, 'task' => $task]);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        Gate::authorize('delete', $task);
        // Melakukan redirect menuju tasks.index
        return redirect()->route('tasks.index');
    }   

    public function progress()
    {
        $title = 'Task Progress';

        $tasks = Task::all();

        $filteredTasks = $tasks->groupBy('status');        

        $tasks = [
            Task::STATUS_NOT_STARTED => $filteredTasks->get(
                Task::STATUS_NOT_STARTED, []
            ),
            Task::STATUS_IN_PROGRESS => $filteredTasks->get(
                Task::STATUS_IN_PROGRESS, []
            ),
            Task::STATUS_IN_REVIEW => $filteredTasks->get(
                Task::STATUS_IN_REVIEW, []
            ),
            Task::STATUS_COMPLETED => $filteredTasks->get(
                Task::STATUS_COMPLETED, []
            ),
        ];

        return view('tasks.progress', [
            'pageTitle' => $title,
            'tasks' => $tasks,
        ]);
    }

    public function move(int $id, Request $request)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('move', $task);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.progress');
    }

    public function cardComplete(Request $request, $id)
    {
        $task = Task::find($id);

        Gate::authorize('complete', $task);

        $task->update([
            'status' => 'completed'
        ]);

        return redirect()->route('tasks.progress');
    }

    public function listComplete(Request $request, $id)
    {
        $task = Task::find($id);

        Gate::authorize('complete', $task);

        $task->update([
            'status' => 'completed'
        ]);

        return redirect()->route('tasks.index');
    }
}
