<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibRequest;
use App\Http\Requests\UpdateLibRequest;
use App\Lib;
use Auth;
use Gate;
use Illuminate\Http\Request;

use App\Http\Requests;
use \Illuminate\Support\Facades\Response;

class LibsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libs = Lib::all();
        return view('libs.index', compact('libs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('libs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLibRequest $request)
    {
        $inputs = $request->input('inputs');
        $body = $request->input('body');
        $title = $request->input('title');

        if(count($inputs)) {
            foreach ($inputs as $input) {

                // remove non alphanumeric values from the input
                $input['value'] = preg_replace("/[^\w]/", "", $input['value']);

                // replace inputs with markup
                $replacement = "{%" . $input['value'] . ":" . $input['speech'] . "%}";
                $pattern = '/<input id="' . $input['id'] . '" placeholder="' . $input['speech'] . '">/';
                $body = preg_replace($pattern, $replacement, $body);
            }
        }

        // remove added non breaking spaces
        $body = preg_replace("/&nbsp;/", " ", $body);

        $lib = new Lib([
            'title' => $title,
            'body' => $body,
        ]);
        Auth::user()->write($lib);

        return redirect('/libs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lib $lib)
    {
        $lib->format('show');
        return view('libs.show', compact('lib'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lib $lib)
    {
        return view('libs.edit', compact('lib'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLibRequest|Request $request
     * @param Lib $lib
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateLibRequest $request, Lib $lib)
    {
        $lib->fill($request->all());
        $lib->save();
        return redirect("/libs/$lib->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lib $lib)
    {
        if(Gate::denies('destroy', $lib)) {
            abort(402);
        }

        $lib->delete();
        return redirect('/libs');
    }

    public function play(Lib $lib)
    {
        $lib->format('play');

        return view('libs.play', compact('lib'));
    }
}
