<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Http\Resources\AnimalsResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return AnimalsResource::collection(Animal::paginate(5));
            $animals = Animal::all();

            if(sizeof($animals, 0) == 0){
                return response()->json(['Message' => 'No animals found'], 404);
            }

            return response()->json($animals);

        } catch(\Exception $e){
            return response()->json(['Message' => $e], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            if(!$request['name'] || !$request['sound']){
                return response()->json(['Error' => 'Send all the requested data'], 400);
            }
            $animalName = $request['name'];
            $animalSound = $request['sound'];

            $data = [
                'name' => $animalName,
                'sound' => $animalSound
            ];

            $response = Animal::create($data);
            return new AnimalsResource($response);

        } catch(\Exception $e){
            return response()->json(['Message' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        try {
            return new AnimalsResource($animal);
        } catch(\Exception $e){
            return response()->json(['Message' => $e], 500);
        }
    }

    public function filter(string $sound)
    {
        try {
            $animals = Animal::whereRaw('LOWER(sound) LIKE ?', ['%'.strtolower($sound).'%'])->paginate(10);

            if($animals->isEmpty()){
                return response()->json(['Message' => 'No animals found'], 404);
            }

            $animalResources = array_map(function ($animal) {
                return new AnimalsResource($animal);
            }, $animals->items());

            return response()->json([
                'data' => $animalResources,
                'meta' => [
                    'current_page' => $animals->currentPage(),
                    'from' => $animals->firstItem(),
                    'last_page' => $animals->lastPage(),
                    'links' => $animals->links()->elements,
                    'path' => $animals->url($animals->currentPage()),
                    'per_page' => $animals->perPage(),
                    'to' => $animals->lastItem(),
                    'total' => $animals->total(),
                ],
            ]);
        } catch(\Exception $e){
            return response()->json(['Message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        try {
            $animal = Animal::where('id', $animal['id'])->first();
            if(!$animal){
                return response()->json(['Messageeeeeeeeeee' => 'Not found'], 404);
            }

            if(!$request['name'] && !$request['sound']){
                return response()->json(['Error' => 'Send all the requested data'], 400);
            }


            if(!$request['name']){
                $animal->update([
                    'sound' => $request['sound']
                ]);
                return new AnimalsResource($animal);
            }

            if(!$request['sound']){
                $animal->update([
                    'name' => $request['name']
                ]);
                return new AnimalsResource($animal);
            }

            $animal->update([
                'name' => $request['name'],
                'sound' => $request['sound']
            ]);

            return new AnimalsResource($animal);
        } catch(\Exception $e){
            return response()->json(['Message' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $animal = Animal::where('id', $id)->first();
            if(!$animal){
                return response()->json(['Message' => 'Not found'], 404);
            }
            $animal->delete();
            return response()->json(['Message' => 'Animal deleted'], 200);
        } catch(\Exception $e){
            return response()->json(['Message' => $e], 500);
        }
    }
}
