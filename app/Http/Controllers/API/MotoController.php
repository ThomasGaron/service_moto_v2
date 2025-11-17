<?php

namespace App\Http\Controllers\API;

use App\Models\Moto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motos = Moto::latest()->paginate(10);
        return response()->json( 
            
             $motos,200
    );
    }
 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
       
        $moto = $request->all();
        
        $request->validate([
        'title'     => 'required',
        'content'   => 'required',
        'photo'     => 'required|image'
    ]);

     
  
    if ($moto = $request ->file('photo')){
        $image = $request->photo;
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->move('images/upload', $fileName, 'public');
      // $moto=$request-> $fileName ;
      // $moto = $fileName ;
    }

 $moto =  Moto::create([
    'title' => $request->input('title'),
    'content' => $request->input('content'),
    'photo' => $fileName,
]);
  
      // On retourne les informations du nouvel moto en JSON
     return response()->json([$moto,"message" => "Moto ajouté"], 201);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moto  $moto
     * @return \Illuminate\Http\Response
     */
     public function show( $id)
    {
     /*    return [
            "status" => 1,
            "data" =>$moto
        ]; */
          // On retourne les informations de l'moto en JSON
          //return response()->json($id);
          return Moto::find($id);
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moto  $moto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $moto = Moto::findOrFail($id);
        if (!$moto) {
            return response() ->json(['message' => 'Id not found'], 404);
        }
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=> 'required',
            'photo'=> 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        if ($validator->fails()) {
            return response() ->json(['success' => false, 'message' => $validator->errors()], 400);
        }
 
        if ($request->hasfile('photo')) {
            $image = $request->photo;
            $fileName = time() . '.' . $image->getClientOriginalName();
            $path = $request->photo->storeAs('images/upload', $fileName, 'public');
            $moto['photo'] = $path;
    
        }
        $moto->update($request->except('photo'));

        return response()->json([$moto,"message" => "moto modifé avec succée" ] );
       

    }

  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moto  $moto
     * @return \Illuminate\Http\Response
     */
     //public function destroy(string $moto)
     public function destroy(string $id)
    {
        //verssion simple sans image
  /*         // On supprime l'moto
    $moto->delete();
    // On retourne la réponse JSON
    return response()->json(); */

    $moto = Moto::findOrFail($id);
    if ($artimotocle->photo) {
        Storage::disk('public')->delete($moto->photo);
    }
      $moto->delete();
    return response()->json(null, 204);




    }
}