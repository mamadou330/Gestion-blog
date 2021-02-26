<?php

function e(string $string)
{
    return strip_tags(htmlentities($string));
}