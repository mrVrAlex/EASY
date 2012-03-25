<?php
setlocale(LC_ALL,"rus");
setlocale(LC_ALL,"rus.1251");
setlocale(LC_ALL,NULL);
echo mb_convert_encoding(strftime('%B', mktime(1,1,1,11,1,2000)),'UTF-8','windows-1251');
