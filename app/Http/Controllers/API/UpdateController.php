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

    //Menampilkan data index
    public function index()
    {

        $updates = update::with('features')->simplePaginate(5);
        $last3 = DB::table('updates')->latest('id')->first();
        return response()->json([
            'status' => true,
            'message' => "Update List",
            'data' => $updates
        ], 200);

    }
     // Get Recent
    public function getrecentup(){
        try{
            $parent = $this->update->orderBy('id', 'desc')->firstOrFail();
            // $pid = $this->updates->first();
            $features = feature::where('note_id', '=', $parent->id)->get();
            return response()->json(['List updates recent' => $parent , 'features' => $features], 300);
        }catch (ModelNotFoundException){
            return response()->json(['List update recent' => [], 'Error' => '404', 'Message' => 'Item not found or not created yet!'], 404 );
        }
    }
     // Get update by Id
    public function getupdate($id) {
        try{
            $parent = $this->updates->findOrFail($id);
            $features = feature::where('note_id', '=', $id)->get();
            return response()->json(['List updates by id' => $parent , 'All features by id' => $features ], 300);
        }catch (ModelNotFoundException){
            return response()->json(['Error' => '404', 'Message' => 'Item not found or not created yet!'], 404 );
        }
    }
    //Notif untuk delete
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

    public function create()
    {
        //
    }
    //Store
    public function store(Request $request)
    {
        $this->validate($request, [
            'tittle' => ['required', 'string'],
            'version' => ['required', 'string'],
            'features' => ['required', 'array'],
            'features.*' => ['required', 'string']
            ]);

            $note = update::create([
            'tittle' => $request->tittle,
            'version' => $request->version
            ]);

            foreach ($request->features as $f) {
            feature::create([
            'feature' => $f,
            'note_id' => $note->id
            ]);
            }

            return $this->getrecentup();
            return response()->json([
            'update berhasil'
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Get by Id
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
    // Delete Update
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
