<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();

        return view('dashboard.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('dashboard.category.create', []);
    }

    public function store(Request $request)
    {
        //$this->validate(
        //    $request,
        //    [ 'name' => '', 'slug' => '', 'data' => '', 'position' => '', ],
        //    [],
        //    trans('categories.attributes')
        //);

        $category = new Category();

        /** @type Category $category */

        $category->fill($request->all());

        $category->save();

        return redirect()->route("dashboard.category.index")->withMessage('common.success');
    }

    public function show(Request $request, $id)
    {
        $category = Category::find($id);

        /** @type Category $category */

        return view('dashboard.category.show', ['category' => $category]);
    }

    public function edit($id)
    {
        $category = Category::find($id);

        /** @type Category $category */

        return view('dashboard.category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        //$this->validate(
        //    $request,
        //    [ 'name' => '', 'slug' => '', 'data' => '', 'position' => '', ],
        //    [],
        //    trans('categories.attributes')
        //);

        $category = Category::find($id);

        /** @type Category $category */

        $category->fill(request()->all());

        $category->save();

        return redirect()->route("dashboard.category.edit", $category->id)->withMessage('common.success');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);

        /** @type Category $category */

        $category->delete();

        return redirect()->route("dashboard.category.index")->withMessage('common.success');
    }

}
