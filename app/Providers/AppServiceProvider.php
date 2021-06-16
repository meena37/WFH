<?php

  namespace App\Providers;

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Support\ServiceProvider;

  class AppServiceProvider extends ServiceProvider
  {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      //Paginator::useBootstrapThree();
      Schema::defaultStringLength(191);

      global $task_status;
      $task_status = [
        1 => 'To Do',
        2 => 'In Progress',
        3 => 'Paused',
        4 => 'Verify',
        5 => 'Done',
      ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      //
    }
  }