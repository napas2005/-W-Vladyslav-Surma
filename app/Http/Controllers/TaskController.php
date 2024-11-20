<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{

    public function lists($slug)
    {
        $userId = Auth::id();

        $category_slug = $slug;

        $tasks = Category::whereActive(1)
            ->whereTranslation('slug', $slug)
            ->with(['tasks' => function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('is_completed', 0)
                    ->with('priority');
            }])
            ->firstOrFail()
            ->tasks;

        return view('layouts.task.category', compact('tasks', 'category_slug'));
    }

    public function create($slug)
    {
        $priority = Priority::all();

        $category_slug = $slug;

        return view('layouts.task.form_create', compact('priority', 'category_slug'));
    }

    public function store(TaskRequest $request, $slug)
    {
        $userId = Auth::id();

        $categoryId = Category::whereTranslation('slug', $slug)
            ->firstOrFail()
            ->id;

        $newslug = Str::slug($request->input('title'));

        if (Task::where('slug', $newslug)->exists()) {
            $newslug = $this->makeUniqueSlug($newslug);
        }

        $validatedData = $request->validated();

        Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'priority_id' => $validatedData['priority_id'],
            'slug' => $newslug,
            'user_id' => $userId,
            'category_id' => $categoryId,
        ]);

        return redirect()->route('tasks.list', ['slug' => $slug])->with('success', 'Завдання успішно додано!');
    }

    public function edit($slug)
    {

        $task = Task::where('slug', $slug)->with('priority')->firstOrFail();

        $priority = Priority::all();

        $category_slug = Category::where('id', $task->category_id)
            ->first()
            ->slug;

        return view('layouts.task.form', compact('task', 'priority', 'category_slug'));
    }

    public function update(TaskRequest $request, $id, $slug)
    {
        $task = Task::where('id', $id)->firstOrFail();

        if ($request->input('title') != $task->title) {
            $newslug = Str::slug($request->input('title'));

            if (Task::where('slug', $newslug)->exists()) {
                $newslug = $this->makeUniqueSlug($newslug);
            }

            $task->slug = $newslug;
        }

        $task->update($request->validated());

        return redirect()->route('tasks.list', ['slug' => $slug])->with('success', 'Завдання успішно оновлено!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'is_completed' => 'required|boolean',
        ]);

        $task->is_completed = $request->is_completed;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function completedTasks($slug)
    {
        $userId = Auth::id();

        $tasks = Category::whereActive(1)
            ->whereTranslation('slug', $slug)
            ->with(['tasks' => function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('is_completed', 0)
                    ->with('priority');
            }])
            ->firstOrFail()
            ->tasks;

        return view('layouts.task.table.task_table', compact('tasks'))->render();
    }

    public function filterTasks(Request $request, $slug)
    {
        $isCompleted = $request->query('is_completed', null);

        $category = Category::whereTranslation('slug', $slug)->firstOrFail();
        $query = $category->tasks()->where('user_id', Auth::id());

        if (!is_null($isCompleted)) {
            $query->where('is_completed', $isCompleted);
        }

        $tasks = $query->with('priority')->get();

        return view('layouts.task.table.task_table', compact('tasks'))->render();
    }



    private function makeUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;

        while (Task::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
