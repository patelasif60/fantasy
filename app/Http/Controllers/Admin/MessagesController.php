<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
        $value = setting($key);

        return view('admin.message.edit', compact('leagueInfoMessage', 'key', 'value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->has('key') && $request->has('content')) {
            $validator = Validator::make($request->all(), [
                'key' => 'required',
                'content' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
        }

        setting([$request->get('key') => $request->get('content')])->save();

        flash(__('messages.data.saved.success'))->success();

        return redirect()->route('admin.message.edit', ['key' => $request->get('key')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($key)
    {
        setting([$key => ''])->save();
        flash(__('messages.data.deleted.success'))->success();

        return redirect()->route('admin.dashboard.index');
    }
}
