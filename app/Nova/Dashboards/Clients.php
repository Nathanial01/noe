<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ChecksPerDay;
use App\Nova\Metrics\ClientsPremium;
use App\Nova\Metrics\ClientsProfessional;
use App\Nova\Metrics\ClientsProfessionalXl;
use App\Nova\Metrics\ClientsStandard;
use App\Nova\Metrics\ClientsWhitelabel;
use Laravel\Nova\Cards\Help;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\UsersPerDay;
use App\Nova\Metrics\NewCompanies;
use App\Nova\Metrics\TotalRevenue;
use App\Nova\Metrics\NewProperties;
use App\Nova\Metrics\RevenuePerDay;
use App\Nova\Metrics\CompaniesPerDay;
use App\Nova\Metrics\LeadsPerDay;
use App\Nova\Metrics\NewChecks;
use App\Nova\Metrics\NewClients;
use App\Nova\Metrics\NewLeads;
use App\Nova\Metrics\NewPortfolio;
use App\Nova\Metrics\PortfolioPerDay;
use App\Nova\Metrics\PropertiesPerDay;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Clients extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
          new NewClients,
          new ClientsStandard,
          new ClientsPremium,
          new ClientsProfessional,
          new ClientsProfessionalXl,
          new ClientsWhitelabel
        ];
    }


}
