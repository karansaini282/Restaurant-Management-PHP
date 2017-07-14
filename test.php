<?php
$duedate=DateTime::createFromFormat('d-m-Y','10-12-2012');
$returndate=DateTime::createFromFormat('d-m-Y','11-11-2012');
$difference = $duedate->diff($returndate);
print_r($difference);
$day=$difference->format('%a');
echo $day;
$sign=$difference->format('%R');
echo $sign;
?>