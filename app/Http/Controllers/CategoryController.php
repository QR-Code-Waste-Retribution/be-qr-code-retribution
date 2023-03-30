<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('district_id', auth()->user()->district_id)
            ->where('parent_id', '!=', null)
            ->paginate(10);
        return view('pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'harga_tarif' => 'required',
        ], [
            'required' => 'Input :attribute tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create([
            'name' => $request->nama_kategori,
            'description' => fake()->text(),
            'price' => $request->harga_tarif,
            'type' => 'month',
            'parent_id' => null,
            'district_id' => 1,
        ]);

        return redirect()->route('category.index')->with([
            'type' => 'Successfully to create category',
            'status' => 'Yeyyyy, Anda berhasil menambahkan Kategori Baru',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function changeStatusCategory(Request $request)
    {
        try {
            $category = Category::find($request->category_id);
            $category->status = !$category->status;
            $category->save();

            return $this->successResponse($category, 'Success to change category status');
        } catch (Exception $err) {
            return $this->errorResponse([], 'Something went wrong');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
