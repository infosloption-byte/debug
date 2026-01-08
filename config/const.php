<?php

define('FILE_TYPES', [
    'pdf' => 'file-pdf',
    'doc' => 'file-word',
    'docx' => 'file-word',
    'xls' => 'file-excel',
    'xlsx' => 'file-excel',
    'ppt' => 'file-powerpoint',
    'pptx' => 'file-powerpoint',
    'txt' => 'file-alt',
    'png' => 'image',
    'jpg' => 'image',
    'jpeg' => 'image',
]);

//PREFIX 
define('PREFIX',[
    'complain'      => 'CM',
    'job'           => 'JB',
    'service'       => 'SV'
]);

//Complain
define('COMPLAIN_PENDING',0);
define('COMPLAIN_APPROVED',1);
define('COMPLAIN_REJECTED',2);
define('JOB_CREATED',3);

//Job
define('JOB_PENDING',0);
define('JOB_DONE',1);
define('JOB_REJECTED',2);
define('SERVICE_CREATED',3);

//Job
define('SERVICE_PENDING',0);
define('SERVICE_DONE',1);