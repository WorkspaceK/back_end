<?php


$requests = [
    'PublicationAuthorRequest',
    'StatusRequest',
    'DepartmentRequest',
    'PositionRequest',
    'MajorRequest',
    'ResearchFieldRequest',
//    'PersonRequest',
    'DegreeRequest',
    'AcademicRankRequest',
    'EmployeeRequest',
    'EmployeeResearchFieldRequest',
    'ProjectRequest',
    'ProjectTypeRequest',
    'PublicationTypeRequest',
//    'PublicationRequest'
];

$module = 'Admin';

foreach ($requests as $request) {
    exec("php artisan module:make-request {$request} {$module}");
    echo "Created: {$request}\n";
}
