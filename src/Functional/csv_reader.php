<?php
/**
 * Created by PhpStorm.
 * User: Avramets
 * Date: 23.09.2021
 * Time: 12:06
 * Чтение CSV файла на входе - JSON на выходе
 */

namespace Drupal\skytegs\Plugin\Functional;

	$assoc_array = csv_to_assoc_array('/data_for_graph/csv/top10_ministry_news.csv', ';');
	
	
	
	$keys = array_keys($assoc_array[0]); 
	$name_chart = $keys[0]; //Замена кириллического названия (например, 'ТОП-10 министерств' на 'name'.
	
	
	foreach ($assoc_array as &$row)
{
    $row['name'] = $row[$name_chart];
	$row['month'] = $row['Месяц'];
	$row['week'] = $row['Неделя'];
	$row['day'] = $row['День'];
	unset ( $row[$name_chart] );
	unset( $row['Месяц'] );
	unset( $row['Неделя'] );
	unset( $row['День'] );

}

unset($row);
	
	$str_json = json_encode($assoc_array); 
	$array_search = ['[{', '}]'];
	$array_replace = ['{"ratings":[{', '}]}'];
	
	$str_json_mute = str_replace($array_search, $array_replace, $str_json);
	
	
	echo $str_json_mute;
	
	
	function csv_to_assoc_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
			
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

?>