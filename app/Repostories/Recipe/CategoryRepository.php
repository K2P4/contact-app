<?php

namespace App\Repostories\Recipe;

use App\Models\Category;
use App\Models\Recipe;
use App\Repostories\Base\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}
