<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\update;
use App\Models\feature;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function __construct(Update $updates, Feature $features, Request $request)
    {
        $this->update = $updates;
        $this->feature =$features;

    }

    public function index(feature $features, Update $updates)
    {
        $questionLimit=$features->count();
        $response=[];
        for($i=0;$i<$questionLimit;$i++){
        $questions['candidate_chosen_ans'] = $updates[$i];
        $response[$i]=[
            'question_with_choice'=>$questions[$i],
        ];
}
return response($response);

        // $updates = update::simplePaginate(5);
        // $last3 = DB::table('updates')->latest('id')->first();
        // return response()->json([
        //     'status' => true,
        //     'message' => "Update List",
        //     'data' => $updates
        // ], 200);
    }

    public function updateInfo()
    {
        return response()->json([
            'status' => true,
            'message' => "Data berhasil dihapus",
        ], 200);
    }

    public function updateList()
    {
        $updates = update::latest()->simplePaginate(5);
    }

    public function getFeatures()
    {
        $features = Feature::whereNull('note_id')
            ->with('features')
            ->orderby('feature')
            ->get();
        return view('categories', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate($request, [
            'tittle' => 'required|string',
            'version' => 'required|string',
            'feature.*' => 'required|string',
      ]);
      $features = $request->feature;
      $fts = [];
      foreach ($features as $feat ){
          array_push($fts, feature::create($feat));
      }
      $this->update->create($request->all());
      return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $updates = update::find($id);
        if (is_null($updates)) {
        return $this->sendError('Not found.');
        }
        return response()->json([
        "success" => true,
        "message" => "Update List.",
        "data" => $updates
]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->update->findOrFail($id);
            $item->delete();
            return $this->updateInfo();
        } catch (ModelNotFoundException) {
            return response(['message' => 'Not Found!', 'status' => 404]);
        }
    }
}
