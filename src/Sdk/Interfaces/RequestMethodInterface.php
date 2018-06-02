<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestMethodInterface
{
    public const CREATE = 'create';
    public const LIST = 'list';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
}
