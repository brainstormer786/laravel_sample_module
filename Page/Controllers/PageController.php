<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Models\Page;
use Illuminate\Http\Request;
use App\Modules\Product\Models\Category;
use Exception;

/**
 * Handle product category functionality
 */
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $display = $request->get('display') ?? '';
        $page = ($page*20)-19;
        $searchParams = $request->all();

        $pages = [];
        if ($display=='all') {
            $pages = Page::getPagesForAdminList(false, $searchParams);
        } else
            $pages = Page::getPagesForAdminList(true, $searchParams);

        return view("page.index", ['pages'=>$pages, 'page'=>$page, 'display' => $display, 'searchParams' => $searchParams, 'search'=>$request->has('search')]);
    }

    /**
     * Display a list of the hidden pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashedList(Request $request)
    {
        $pages = [];
        $pages = Page::onlyTrashed()->paginate(20);

        return view("page.trashed", ['pages'=>$pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::pageCategory();
        return view('page.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(), Page::getValidationRules())->validate();
     
        try {
            \DB::beginTransaction();
            $path = '';
            
            //creating user in local database
            $page = new Page();
            $data = $request->all();
            
            $page->fill($data['page']);
                       
            if(!$page->save())
                throw new Exception('Page did not save.');

            $linkName = preg_replace('/\s+/', '_', strtolower($page->name));
            $page->link_name_pag = $linkName."_".$page->id;
            $page->save();

            \DB::commit();

            return redirect('page')->with('success','Page created successfully!');

        } catch(\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
            return back()->withInput($request->all())->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page   =   Page::findOrFail($id);
        $catid  =   $page->link_to_cat;
        $categories = Category::where('parent_id',25)->whereNull('category_id')->orderBy('name', 'ASC')->get();
        
        return view("page.create", ['categories'=>$categories, 'page'=>$page]);
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
        $rules = Page::getValidationRules();
        $rules['page.name'] = 'required|unique:pages,name,'.$id;
        \Validator::make($request->all(), $rules)->validate();
     
        try {
            \DB::beginTransaction();
            $path = '';
            
            //creating user in local database
            $page = Page::findOrFail($id);
            $data = $request->all();
            
            $page->fill($data['page']);
                       
            if(!$page->save())
                throw new Exception('Page did not save.');

            $linkName = preg_replace('/\s+/', '_', strtolower($page->name));
            $page->link_name_pag = $linkName."_".$page->id;
            $page->save();

            \DB::commit();

            return redirect('page')->with('success','Page updated successfully!');

        } catch(\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
            return back()->withInput($request->all())->with('error', $e->getMessage());
        }
        
    }

    public function previewPage() {
        return view("page.previewPage");
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
    
        return redirect('/page')->with('success','Page hidden successfully!');
    }

    /**
     * Restore trashed page from soft delete list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreTrashedPage($id)
    {
        Page::withTrashed()->find($id)->restore();
        
        return redirect('/page')->with('success','Page restored successfully!');
    }
    
}
