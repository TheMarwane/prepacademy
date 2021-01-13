<?php

namespace App\Service;

class ContestService
{
    public function getRewards(Array $winnings, int $chaine): int
    {
        $nbContests = count($winnings);
        if($chaine >= $nbContests) {return array_sum($winnings);} // si on peut participer à tous les concours


    }

    /**
     * Retourne le nombre le plus proche de zéro dans la liste
     * (en cas d'égalité, retournera le positif)
     *
     * @param array $numbers
     * @return int
     */
    public function getNearestToZero(Array $numbers): int
    {
        $nearest = $numbers[0];
        $nearestPos = $nearest >= 0 ? $nearest : $nearest * -1;

        // balayage de tous les nombres
        for($i = 1 ; $i < count($numbers) ; $i++) {
            $numPos = $numbers[$i] >= 0 ? $numbers[$i] : $numbers[$i] * -1;

            if(
                $numPos < $nearestPos ||    // si le nombre est plus proche de zéro
                ($numPos === $nearestPos && $numbers[$i] > $nearest) // s'il est identique mais positif
            ) {
                $nearest = $numbers[$i];
                $nearestPos = $numPos;
            }
        }

        return $nearest;
    }
}