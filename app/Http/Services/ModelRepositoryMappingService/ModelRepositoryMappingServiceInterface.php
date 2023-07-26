<?php

namespace App\Http\Services\ModelRepositoryMappingService;

interface ModelRepositoryMappingServiceInterface
{
    public function getRepository(string $model);
}
