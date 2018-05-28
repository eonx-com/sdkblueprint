<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject;

use LoyaltyCorp\SdkBlueprint\Sdk\DataTransferObject;

/**
 * @method TransactionDtoStub getTransaction()
 * @method self setTransaction(TransactionDtoStub $transaction)
 */
class AssemblableObjectObjectStub extends DataTransferObject
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
