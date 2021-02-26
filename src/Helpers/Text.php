<?php
namespace App\Helpers;

class Text 
{
    
    /**Fonction qui permet de couper le text au soixantieme caratere
     * excerpt
     *
     * @param  mixed $content
     * @param  mixed $limit
     * @return void
     */
    public static function excerpt(string $content, int $limit = 60) 
    {
        if(mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}