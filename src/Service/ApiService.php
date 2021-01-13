<?php

namespace App\Service;

use App\Entity\Category;

class ApiService
{
    /**
     * Calcule le nombre total d'items de la catégorie et de ses enfants
     *
     * @param Category $categ
     * @return int
     */
    public function getNbItemsByCateg(Category $categ)
    {
        $total = count($categ->getItems());

        foreach ($categ->getChildren() as $childCateg) {
            $total += $this->getNbItemsByCateg($childCateg);
        }

        return $total;
    }

}