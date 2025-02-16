<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Repostories\Recipe\RecipeRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    protected $recipeRepo;

    public function __construct(RecipeRepository $recipeRepo)
    {
        $this->recipeRepo = $recipeRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = $this->recipeRepo->query();
            $filters = $request->only('category');

            $recipes = $this->recipeRepo->filterCategory($query, $filters)->latest()->paginate(6);

            return response()->json($recipes, 200);
        } catch (Exception $e) {

            return response()->json([
                'errors' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
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

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
            $data['image'] = Storage::disk('public')->url($path);
        }

        return new RecipeResource($this->recipeRepo->create($data));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)

    {
        $recipe = $this->recipeRepo->find($id);

        if (!$recipe) {
            return response()->json([
                'message' => 'recipe not found',
                'status' => 404
            ], 404);
        }

        return $recipe;
    }



    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');

            return response()->json(['path' => asset("storage/$imagePath")], 200);
        }


        return response()->json(['error' => 'No file uploaded'], 400);
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function update($id, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required',
        ]);


        return new RecipeResource($this->recipeRepo->update($id, $data));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Recipe $recipe)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->recipeRepo->delete($id);
    }
}
