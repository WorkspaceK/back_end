<?php

$controllers = [

//    'PublicationAuthorController',
    'StatusController',
    'DepartmentController',
    'PositionController',
    'MajorController',
    'ResearchFieldController',
//    'PersonController',
    'DegreeController',
    'AcademicRankController',
    'EmployeeController',
    'EmployeeResearchFieldController',
    'ProjectController',
    'ProjectTypeController',
    'PublicationTypeController',
//    'PublicationController'
];

$module = 'Admin';

foreach ($controllers as $controller) {
    exec("php artisan module:make-controller {$controller} {$module}");
    echo "Created: {$controller}\n";
}
