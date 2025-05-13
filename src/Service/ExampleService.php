<?php

namespace App\Service;

use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;

final class ExampleService
{
    private $adminContextProvider;

    public function __construct(AdminContextProvider $adminContextProvider)
    {
        $this->adminContextProvider = $adminContextProvider;
    }

    public function someMethod()
    {
        $context = $this->adminContextProvider->getContext();
    }

}