<?php
function only_uppercase($str)
{
    $result = "";
    for ($i = 0; $i < strlen($str); $i++)
    {
        $character = substr($str, $i, 1);
        if (ctype_upper($character))
            $result = $result . $character;
    }
    return $result;
}

function string_contents_distance($str1, $str2)
{
    $str1 = strtolower($str1);
    $str2 = strtolower($str2);
    if (strcmp($str1, $str2) == 0)
        return 0;
    $pos = strpos($str2, $str1);
    if ($pos === 0)
        return 0;
    else if ($pos !== FALSE)
        return 3;
    return strlen($str1) + strlen($str2);
}

function string_distance($str1, $str2)
{
    return min(levenshtein(strtolower($str1), strtolower($str2)),
                string_contents_distance($str1, only_uppercase($str2)) + 2,
                string_contents_distance(only_uppercase($str1), $str2) + 2,
                string_contents_distance($str1, $str2));
}

function simple_compare($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

function compare_string_distances($a, $b) {
    return simple_compare($a[0], $b[0]);
}

function find_and_sort($result, $criteria, $how_many_results, $search_key_index)
{
    // The following code produces an array of count $how_many_results,
    // containing the results that match $criteria closest.

    $closest_results = array();

    while ($row = mysql_fetch_row($result)) {
        if (count($closest_results) < $how_many_results)
        {
            array_push($closest_results, array(string_distance($criteria, $row[$search_key_index]), $row));
        }
        else
        {
            $levenshtein_distance = string_distance($criteria, $row[$search_key_index]);
            foreach($closest_results as &$closest_result)
            {
                if ($closest_result[0] > $levenshtein_distance)
                {
                    $closest_result[0] = $levenshtein_distance;
                    $closest_result[1] = $row;
                    break;
                }
            }
        }
    }

    // The following code sorts $closest_results by how close they are to the criteria.

    usort($closest_results, 'compare_string_distances');

    // Here, we format $closest_results so that it adheres to the format expected
    // by jQuery Autocomplete.

    foreach($closest_results as &$closest_result)
    {
        $closest_result = array("label" => $closest_result[1][1],
                                "value" => array(
                                    "distance" => $closest_result[0],
                                    "data" => $closest_result[1]));
    }
    
    return $closest_results;
}

?>