<?php

namespace App\Providers;

use App\Interfaces\ProfilesRepositoryInterface;
use App\Interfaces\RelCostumerIntructionsRepositoryInterface;
use App\Interfaces\BoutiqueContactRepositoryInterface;
use App\Interfaces\BoutiqueRepositoryInterface;
use App\Interfaces\CostumerRepositoryInterface;
use App\Interfaces\EmployeesRepositoryInterface;
use App\Interfaces\PickUpCompanyRepositoryInterface;
use App\Interfaces\UsersRepositoryInterface;
use App\Interfaces\ModulesRepositoryInterface;
use App\Interfaces\LabelCreateContentRepositoryInterface;
use App\Interfaces\LabelCreateSizeRepositoryInterface;
use App\Interfaces\LabelsRepositoryInterface;
use App\Interfaces\ShippersRepositoryInterface;
use App\Interfaces\BoxesRepositoryInterface;
use App\Interfaces\ReceiveRepositoryInterface;
use App\Interfaces\ReceiveDetailsRepositoryInterface;
use App\Interfaces\RelProfileModuleRepositoryInterface;
use App\Interfaces\RelUserProfileRepositoryInterface;
use App\Interfaces\RelBoutiquesCustomerInstructionsRepositoryInterface;
use App\Interfaces\CustomerNoProcessRepositoryInterface;
use App\Interfaces\ReceiveSupportsRepositoryInterface;
use App\Interfaces\PreBillingRepositoryInterface;
use App\Interfaces\ProcessingRepositoryInterface;
use App\Interfaces\ProcessAddWorkRepositoryInterface;
use App\Interfaces\RelProcessAddWorkRepositoryInterface;
use App\Interfaces\ProductsRepositoryInterface;

use \App\Repositories\ProfilesRepository;
use App\Repositories\RelCostumerInstructionsRepository;
use App\Repositories\BoutiqueContactRepository;
use App\Repositories\BoutiqueRepository;
use App\Repositories\CostumerRepository;
use App\Repositories\EmployeesRepository;
use App\Repositories\PickUpCompanyRepository;
use App\Repositories\UsersRepository;
use App\Repositories\ModulesRepository;
use App\Repositories\LabelCreateContentRepository;
use App\Repositories\LabelCreateSizeRepository;
use App\Repositories\LabelsRepository;
use App\Repositories\ShippersRepository;
use App\Repositories\BoxesRepository;
use App\Repositories\ReceiveRepository;
use App\Repositories\ReceiveDetailsRepository;
use App\Repositories\RelProfileModuleRepository;
use App\Repositories\RelUserProfileRepository;
use App\Repositories\RelBoutiquesCustomerInstructionsRepository;
use App\Repositories\CustomerNotProcessRepository;
use App\Repositories\ReceiveSupportRepository;
use App\Repositories\PreBillingRepository;
use App\Repositories\ProcessingRepository;
use App\Repositories\ProcessAddWorkRepository;
use App\Repositories\RelProcessAddWorkRepository;
use App\Repositories\ProductsRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UsersRepositoryInterface::class , UsersRepository::class);
        $this->app->bind(EmployeesRepositoryInterface::class,EmployeesRepository::class);
        $this->app->bind(PickUpCompanyRepositoryInterface::class , PickUpCompanyRepository::class);
        $this->app->bind(CostumerRepositoryInterface::class,CostumerRepository::class);
        $this->app->bind(BoutiqueRepositoryInterface::class,BoutiqueRepository::class);
        $this->app->bind(BoutiqueContactRepositoryInterface::class , BoutiqueContactRepository::class);
        $this->app->bind(RelCostumerIntructionsRepositoryInterface::class, RelCostumerInstructionsRepository::class);
        $this->app->bind(ProfilesRepositoryInterface::class, ProfilesRepository::class);
        $this->app->bind(ModulesRepositoryInterface::class, ModulesRepository::class);
        $this->app->bind(LabelCreateContentRepositoryInterface::class, LabelCreateContentRepository::class);
        $this->app->bind(LabelCreateSizeRepositoryInterface::class, LabelCreateSizeRepository::class);
        $this->app->bind(LabelsRepositoryInterface::class, LabelsRepository::class);
        $this->app->bind(ShippersRepositoryInterface::class, ShippersRepository::class);
        $this->app->bind(BoxesRepositoryInterface::class, BoxesRepository::class);
        $this->app->bind(ReceiveRepositoryInterface::class, ReceiveRepository::class);
        $this->app->bind(ReceiveDetailsRepositoryInterface::class, ReceiveDetailsRepository::class);
        $this->app->bind(RelProfileModuleRepositoryInterface::class, RelProfileModuleRepository::class);
        $this->app->bind(RelUserProfileRepositoryInterface::class, RelUserProfileRepository::class);
        $this->app->bind(RelBoutiquesCustomerInstructionsRepositoryInterface::class, RelBoutiquesCustomerInstructionsRepository::class);
        $this->app->bind(CustomerNoProcessRepositoryInterface::class, CustomerNotProcessRepository::class);
        $this->app->bind(ReceiveSupportsRepositoryInterface::class, ReceiveSupportRepository::class);
        $this->app->bind(PreBillingRepositoryInterface::class, PreBillingRepository::class);
        $this->app->bind(ProcessingRepositoryInterface::class, ProcessingRepository::class);
        $this->app->bind(ProcessAddWorkRepositoryInterface::class, ProcessAddWorkRepository::class);
        $this->app->bind(RelProcessAddWorkRepositoryInterface::class, RelProcessAddWorkRepository::class);
        $this->app->bind(ProductsRepositoryInterface::class, ProductsRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
