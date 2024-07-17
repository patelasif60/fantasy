<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GameGuideDataTable;
use App\Http\Controllers\Controller;
use App\Models\GameGuide;
use Illuminate\Http\Request;

class GameGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.gameguide.index');
    }

    public function data(GameGuideDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gameguide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = GameGuide::count();
        $data['section'] = $request->all()['section'];
        $data['content'] = $request->all()['content'];
        $data['order'] = $order + 1;

        if (GameGuide::create($data)) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.gameguide.index');
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
    public function edit(GameGuide $gameguide)
    {
        return view('admin.gameguide.edit', compact('gameguide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GameGuide $gameguide)
    {
        $data['section'] = $request->all()['section'];
        $data['content'] = $request->all()['content'];

        $gameguide->fill([
            'section' => $request->all()['section'],
            'content' => $request->all()['content'],
        ]);

        if ($gameguide->save()) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.gameguide.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameGuide $gameguide)
    {
        if ($gameguide->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.gameguide.index');
    }
}
