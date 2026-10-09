<?php
$arr = explode('[', $wordtext);
$arr1 = explode(')', $wordtext);
echo'<pre>';
print_r('ques0');
print_r($arr1[0]);
print_r('ques1');
print_r($arr1[1]);
print_r('ques2');
print_r($arr1[2]);
print_r('ques3');
print_r($arr1[3]);
die;
?>