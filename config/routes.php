<?php

return [
    '~^/form$~' => ['controller' => StudentList\Controllers\StudentController::class, 'action' => 'getForm'],
    '~^/(\d+)$~' => ['controller' => StudentList\Controllers\ListController::class, 'action' => 'getListForPage'],
    '~^/$~' => ['controller' => StudentList\Controllers\ListController::class, 'action' => 'getListForPage']
];