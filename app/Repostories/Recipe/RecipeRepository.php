<?php

namespace App\Repostories\Recipe;

use App\Models\Recipe;
use App\Repostories\Base\BaseRepository;

class RecipeRepository extends BaseRepository
{
    public function __construct(Recipe $recipe)
    {
        parent::__construct($recipe);
    }

    public function filterCategory($query, $filters)
    {
        return parent::filterCategory($query, $filters);
    }
}
