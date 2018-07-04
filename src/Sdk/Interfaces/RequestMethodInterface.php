<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestMethodInterface
{
    /**
     * The create method.
     *
     * @var string
     */
    public const CREATE = 'create';

    /**
     * The delete method.
     *
     * @var string
     */
    public const DELETE = 'delete';

    /**
     * The get method.
     *
     * @var string
     */
    public const GET = 'get';

    /**
     * The list method.
     *
     * @var string
     */
    public const LIST = 'list';

    /**
     * The update method.
     *
     * @var string
     */
    public const UPDATE = 'update';
}
