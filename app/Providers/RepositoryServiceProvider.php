<?php

namespace App\Providers;

use App\Repository\EloquentRepositoryInterface; 
use App\Repository\UserRepositoryInterface; 
use App\Repository\Eloquent\UserRepository; 
use App\Repository\Eloquent\CRUDRepository;
use App\Repository\Eloquent\Interfaces\CarModelRepositoryInterface;
use App\Repository\Eloquent\Interfaces\CarTypeModelRepositoryInterface;
use App\Repository\Eloquent\Repo\CarModelRepository;
use App\Repository\Eloquent\Repo\CarTypeModelRepository;
use Illuminate\Support\ServiceProvider; 

/** 
* Class RepositoryServiceProvider 
* @package App\Providers 
*/ 
class RepositoryServiceProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
    //    $this->app->bind(EloquentRepositoryInterface::class, CRUDRepository::class);
    //    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    //    $this->app->bind(CarModelRepositoryInterface::class, CarModelRepository::class);
    //    $this->app->bind(CarTypeModelRepositoryInterface::class, CarTypeModelRepository::class);
   }
}