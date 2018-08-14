<?php

namespace App\Canteen\Bls\Canteen;

use App\Admin\Bls\Canteen\Model\RecipesModel;

class RecipesBls
{
    public static function getRecipesByDate($date)
    {
        return RecipesModel::where('date', $date)->first();
    }
}