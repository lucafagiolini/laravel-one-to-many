<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = Project::all();


        return view('admin.project.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.project.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)

    {
        // validation
        $request->validated();

        $project = new Project();
        $project->fill($request->all());

        // check if the image is uploaded
        if ($request->hasFile('cover_image')) {
            // we save the path of the image in a variable
            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            // we save the path of the image in the database
            $project->cover_image = $path;
        }

        $project->save();

        return redirect()->route('admin.project.index')->with('success', 'New Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $categories = Category::all();
        return view('admin.project.show', compact('project', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $categories = Category::all();
        return view('admin.project.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $request->validated();

        $project->update($request->all());

        // check if the image is uploaded
        if ($request->hasFile('cover_image')) {
            // we save the path of the image in a variable
            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            // we save the path of the image in the database
            $project->cover_image = $path;
        }

        $project->save();

        return redirect()->route('admin.project.index')->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.project.index');
    }
}
