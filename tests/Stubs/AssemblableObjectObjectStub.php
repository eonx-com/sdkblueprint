<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\AssemblableObjectInterface;

/**
 * @method TransactionDtoStub getTransaction()
 * @method self setTransaction(TransactionDtoStub $transaction)
 */
class AssemblableObjectObjectStub extends DataTransferObject implements AssemblableObjectInterface
{
    /**
     * {@inheritdoc}
     */
    protected function hasAttributes(): array
    {
        return ['transaction'];
    }

    /**
     * {@inheritdoc}
     */
    public function hasValidationRules(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function embedObjects(): array
    {
        return [
            'transaction' => TransactionDtoStub::class
        ];
    }
}
