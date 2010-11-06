<?php         //header("Content-type:application/vnd.ms-excel"); 
echo $csv->addGrid($data); 
echo $csv->render(); 
?> 