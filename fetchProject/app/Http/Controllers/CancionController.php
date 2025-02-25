<?php

namespace App\Http\Controllers;

use App\Models\Cancion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CancionController extends Controller
{

    public function main()
    {
        return view('main');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json([
            'songs' => Cancion::orderBy('nombre')->paginate(4),
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|unique:canciones|max:100|min:2',
        'artista' => 'required|max:100|min:2',
        'duracion' => 'required|max:100|min:1',
        'genero' => 'required|max:100|min:2',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'result' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $song = new Cancion();
        $song->nombre = $request->nombre;
        $song->artista = $request->artista;
        $song->duracion = $request->duracion;
        $song->genero = $request->genero;
        $result = $song->save();

        return response()->json([
            'result' => true,
            'songs' => Cancion::orderBy('nombre')->paginate(4),
            'user' => Auth::user()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'result' => false,
            'message' => 'The song could not be saved'
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $song = Cancion::find($id);
        $message = '';
        if ($song === null) {
            $message = 'Song not found.';
        }

        return response()->json([
            'message' => $message,
            'song' => $song
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cancion $cancion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = '';
        $song = Cancion::find($id);
        $songs = [];
        $result = false;

        if ($song != null) {
            $validator = Validator::make($request->all(), [
                'nombre'  => 'required|max:100|min:2|unique:canciones,nombre,' . $song->id,
                'artista' => 'required|max:100|min:2',
                'duracion' => 'required|max:100|min:1',
                'genero'  => 'required|max:100|min:2',
            ]);

            if ($validator->passes()) {
                $result = $song->update($request->all());
                if ($result) {
                    $songs = Cancion::orderBy('nombre')->paginate(4)->setPath(url('song'));
                } else {
                    $message = 'The song has not been updated.';
                }
            } else {
                $message = $validator->getMessageBag();
            }
        } else {
            $message = 'Song not found';
        }

        return response()->json(['result' => $result, 'message' => $message, 'songs' => $songs, 'user' => Auth::user()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $message = '';
        $songs = [];
        $song = Cancion::find($id);
        $result = false;
    
        if ($song != null) {
            try {
                $result = $song->delete();
                $songs = Cancion::orderBy('nombre')->paginate(4)->setPath(url('song'));
    
                if ($songs->isEmpty()) {
                    $page = $songs->lastPage();
                    $request->merge(['page' => $page]);
                    $songs = Cancion::orderBy('nombre')->paginate(4)->setPath(url('song'));
                }
    
                $message = 'The song has been deleted successfully.';
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            $message = 'Song not found';
        }
    
        return response()->json([
            'message' => $message,
            'songs' => $songs,
            'result' => $result, 
            'user' => Auth::user()  
        ]);
    }
}