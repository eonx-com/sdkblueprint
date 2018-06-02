<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestMethodInterface
{
    public const CREATE = 'create';
    public const DELETE = 'delete';
    public const GET = 'get';
    public const LIST = 'list';
    public const UPDATE = 'update';
}
