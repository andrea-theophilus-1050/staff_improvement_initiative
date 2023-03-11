<?php

namespace App\Http\Controllers\QALeaders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topics;

class QALeadersController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('role-qa-leaders.category', compact(['categories']))->with('title', 'Category');
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'categoryName' => 'required',
        ]);

        $category = new Category();
        $category->category_name = $request->categoryName;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('qa-leaders.category.management')->with('success', 'Category has been created');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'categoryName' => 'required',
        ]);

        $category = Category::where('category_id', $id)->first();
        $category->category_name = $request->categoryName;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('qa-leaders.category.management')->with('success', 'Category has been updated');
    }

    public function deleteCategory($id)
    {
        $category = Category::where('category_id', $id)->first();
        $category->delete();

        return redirect()->route('qa-leaders.category.management')->with('success', 'Category has been deleted');
    }




    public function topics()
    {
        $topics = Topics::all();
        $categories = Category::all();

        return view('role-qa-leaders.topics', compact(['topics', 'categories']))->with('title', 'QA Leaders');
    }

    public function createTopics(Request $request)
    {
        $request->validate([
            'topicName' => 'required',
            'category' => 'required',
            'firstClosureDate' => 'required',
            'finalClosureDate' => 'required',
        ]);

        $topic = new Topics();
        $topic->topic_name = $request->topicName;
        $topic->category_id = $request->category;
        $topic->topic_description = $request->description;
        $topic->firstClosureDate = $request->firstClosureDate;
        $topic->finalClosureDate = $request->finalClosureDate;
        $topic->save();

        return redirect()->route('qa-leaders.topics.management')->with('success', 'Topic has been created');
    }

    public function updateTopics(Request $request, $id)
    {
        $request->validate([
            'topicName' => 'required',
            'category' => 'required',
            'firstClosureDate' => 'required',
            'finalClosureDate' => 'required',
        ]);

        $topic = Topics::where('topic_id', $id)->first();
        $topic->topic_name = $request->topicName;
        $topic->category_id = $request->category;
        $topic->topic_description = $request->description;
        $topic->firstClosureDate = $request->firstClosureDate;
        $topic->finalClosureDate = $request->finalClosureDate;
        $topic->save();

        return redirect()->route('qa-leaders.topics.management')->with('success', 'Topic has been updated');
    }
}
