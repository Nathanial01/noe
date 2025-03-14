<?php

namespace App\Nova\Tools;

use Laravel\Nova\Tool;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Http\Request;

class NotificationsTool extends Tool
{
    public function menu(Request $request)
    {
        return MenuSection::make('Notifications')
            ->path('/nova/resources/notifications')
            ->icon('bell');
    }
}
