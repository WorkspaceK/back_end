<?php

namespace App\Providers;

use App\Repository\AcademicRank\AcademicRankRepository;
use App\Repository\AcademicRank\AcademicRankRepositoryInterface;
use App\Repository\Degree\DegreeRepository;
use App\Repository\Degree\DegreeRepositoryInterface;
use App\Repository\Department\DepartmentRepository;
use App\Repository\Department\DepartmentRepositoryInterface;
use App\Repository\Employee\EmployeeRepository;
use App\Repository\Employee\EmployeeRepositoryInterface;
use App\Repository\EmployeeResearchField\EmployeeResearchFieldRepository;
use App\Repository\EmployeeResearchField\EmployeeResearchFieldRepositoryInterface;
use App\Repository\Major\MajorRepository;
use App\Repository\Major\MajorRepositoryInterface;
use App\Repository\Person\PersonRepository;
use App\Repository\Person\PersonRepositoryInterface;
use App\Repository\Position\PositionRepository;
use App\Repository\Position\PositionRepositoryInterface;
use App\Repository\Project\ProjectRepository;
use App\Repository\Project\ProjectRepositoryInterface;
use App\Repository\ProjectType\ProjectTypeRepository;
use App\Repository\ProjectType\ProjectTypeRepositoryInterface;
use App\Repository\Publication\PublicationRepository;
use App\Repository\Publication\PublicationRepositoryInterface;
use App\Repository\PublicationAuthor\PublicationAuthorRepository;
use App\Repository\PublicationAuthor\PublicationAuthorRepositoryInterface;
use App\Repository\PublicationType\PublicationTypeRepository;
use App\Repository\PublicationType\PublicationTypeRepositoryInterface;
use App\Repository\ResearchField\ResearchFieldRepository;
use App\Repository\ResearchField\ResearchFieldRepositoryInterface;
use App\Repository\Status\StatusRepository;
use App\Repository\Status\StatusRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(PublicationRepositoryInterface::class, PublicationRepository::class);
        $this->app->bind(AcademicRankRepositoryInterface::class, AcademicRankRepository::class);
        $this->app->bind(PublicationAuthorRepositoryInterface::class, PublicationAuthorRepository::class);
        $this->app->bind(StatusRepositoryInterface::class, StatusRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(MajorRepositoryInterface::class, MajorRepository::class);
        $this->app->bind(ResearchFieldRepositoryInterface::class, ResearchFieldRepository::class);
        $this->app->bind(DegreeRepositoryInterface::class, DegreeRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeResearchFieldRepositoryInterface::class, EmployeeResearchFieldRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ProjectTypeRepositoryInterface::class, ProjectTypeRepository::class);
        $this->app->bind(PublicationTypeRepositoryInterface::class, PublicationTypeRepository::class);
    }
}
