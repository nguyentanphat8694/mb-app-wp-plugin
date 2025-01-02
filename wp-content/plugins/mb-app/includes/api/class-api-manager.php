<?php
namespace MB_App\API;

use MB_App\API\Controllers\Customers_Controller;
use MB_App\API\Controllers\Products_Controller;
use MB_App\API\Controllers\Contracts_Controller;
use MB_App\API\Controllers\Appointments_Controller;
use MB_App\API\Controllers\Staff_Controller;
use MB_App\API\Controllers\Notifications_Controller;

class API_Manager {
    public function __construct() {
        $this->init();
    }

    private function init() {
        // Register controllers
        $controllers = [
            new Customers_Controller(),
            new Products_Controller(),
            new Contracts_Controller(),
            new Appointments_Controller(),
            new Staff_Controller(),
            new Notifications_Controller()
        ];

        foreach ($controllers as $controller) {
            $controller->register_routes();
        }
    }
} 