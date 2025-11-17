<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Moto;

class MotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motos = Moto::latest()->paginate(5);
        return view('motos.index', compact('motos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'title'=>'required',
                'content'=> 'required',
                'user_id'=> 'required',
                'photo'=> 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if ($request->file('photo')->isValid()) {
                $image = $request->file('photo');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images/upload', $fileName, 'public');
            }
            if($validator->fails())
            {
                return redirect()->back()->with('warning','Tous les champs sont requis');   
            }
            else{
           // Article::create($request->all());  
           Moto::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => $request->input('user_id'),
            'photo' => $fileName,
        ]); 
             
            return redirect('admin/motos')->with('success', 'moto ajoutée avec succès');
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $moto = Moto::findOrFail($id);
        return view('motos.show', compact('moto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $moto = Moto::findOrFail($id);

        return view('motos.edit', compact('moto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=> 'required',
            'photo'=> 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        $image = $request ->file('photo');
        $moto = Moto::findOrFail($id);
        if($validator->fails())
        {    //dd($validator);
            return redirect()->back()->with('warning','Tous les champs sont requis');   
        }
        else{
           $moto->title = $request->input('title');
           $moto->content = $request->input('content');
         if ($image)
          {
            $moto -> photo = $image -> getClientOriginalName();     
            $image -> move('images/store', $image -> getClientOriginalName());
          }
         $moto->update();
         return redirect('admin/motos')->with('success', 'moto Modifiée avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $moto = Moto::findOrFail($id);
        $moto->delete();
        return redirect('admin/motos')->with('success', 'moto supprimé avec succès');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->search;
        $motos = Moto::orderby('title','asc')
                    ->select('id','title')
                    ->where('title', 'LIKE', '%'.$search. '%')
                    ->get();
                    $response = array();
                    foreach($motos as $moto){
                        $response[] = array(
                            'value' => $moto->id,
                            'label' => $moto->title
                        );
                          
                    }
                // dd($response); 
                    /* $users = User::orderby('name','asc')
                    ->select('id','name')
                    ->where('name', 'LIKE', '%'.$search. '%')
                    ->get();
                    $response = array();
                    foreach($users as $user){
                        $response[] = array(
                            'value' => $user->id,
                            'label' => $user->name
                        );
                    }
 */

        return response()->json($response);
    } 
}
