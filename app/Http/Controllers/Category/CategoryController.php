<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
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


    public function index(Request $request)
    {

        $search = $request->search ?? '';
        $categories = Category::where('district_id', auth()->user()->district_id)
            ->where('name', 'like', '%' . $search . '%')
            ->where('price', '!=', '0')
            ->paginate(10);

        // return $categories;

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
            'tipe_pembayaran_kategori' => 'required',
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
            'type' => $request->tipe_pembayaran_kategori,
            'parent_id' => null,
            'district_id' => auth()->user()->district_id,
        ]);

        return redirect()->route('category.index')->with([
            'type' => 'success',
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
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'harga_tarif' => 'required',
            'tipe_pembayaran_kategori' => 'required',
        ], [
            'required' => 'Input :attribute tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = Category::find($id);
        $category->name = $request->nama_kategori;
        $category->price = $request->harga_tarif;
        $category->type = $request->tipe_pembayaran_kategori;

        $category->save();

        return redirect()->route('category.index')->with([
            'type' => 'success',
            'status' => 'Yeyyyy, Anda berhasil mengedit Kategori ' . $category->name,
        ]);
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
