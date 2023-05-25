<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos =  Todo::where('user_id', auth()->user()->id)
        ->orderBy('is_complete', 'asc')
        ->orderBy('created_at', 'desc')
        // ->with('category')
        ->get();
        //dd($todos);
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_complete', true)
            ->count();
        return view('todo.index', compact('todos', 'todosCompleted'));
    }
    public function create()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get();
        return view('todo.create', compact('categories'));
    }
    public function edit(Todo $todo)
    {
        // if (auth()->user()->id == $todo->user_id) {
        //    return view('todo.edit', compact('todo'));
        // } else {
        //    return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        // }

        // CODE AFTER REFACTORINGS
        $categories = Category::where('user_id', auth()->user()->id)->get();
        if (auth()->user()->id == $todo->user_id) {
            return view('todo.edit', compact(['todo', 'categories']));
        }
        return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
    }
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'tittle' => 'required|max:255',
            'category_id',
        ]);

        $todo->update([
            'tittle' => ucfirst($request->tittle),
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('todo.index')->with('success', 'Todo Updated Successfully!');
    }

    public function complete(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->update([
                'is_complete' => true,
            ]);
            return redirect()->route('todo.index')->with('success', 'Todo Completed Successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
        }
    }
    public function uncomplete(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->update([
                'is_complete' => false,
            ]);
            return redirect()->route('todo.index')->with('success', 'Todo Uncompleted Successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
        }
    }
    public function destroy(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo Deleted Successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }
    public function destroyCompleted()
    {
        // get all todos for current user where is_completed is true
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_complete', true)
            ->get();
        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }
        // dd($todosCompleted);
        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
    public function store(Request $request, Todo $todo)
    {
        $request->validate([
            'tittle' => 'required|max:255',
            'category_id',
            ]);

        // Practical
        // $todo = new Todo;
        // $todo->tittle = $request->tittle;
        // $todo->user_id = auth()->user()->id;
        // $tood->save();
// Query Builder way
        // DB::table('todos')->insert([
        //      'tittle' => $request->title,
        //      'user_id' => auth()->user()->id,
        //      'created_at' => now(),
        //      'updated_at' =>now(), 
        // ]);

        // Eloquent Way - Readable
        $todo = Todo::create([
            'tittle' => ucfirst($request->tittle),
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            ]);
        
        return redirect()->route('todo.index')->with('success', 'Todo created successfully!');
    }
}