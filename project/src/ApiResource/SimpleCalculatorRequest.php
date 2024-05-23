<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\SimpleCalculatorRequestAction;
use ApiPlatform\OpenApi\Model;
use App\State\SimpleCalculatorRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/Taxes",
            openapi: new Model\Operation(
                summary: 'Calcul du montant des taxes',
                description: 'Permet de calculer le montant de la taxe foncière/Ordures Menageres',
            ),
            //controller: SimpleCalculatorRequestAction::class,
            normalizationContext: ['groups' => ['simple_calculator_request:read']],
            denormalizationContext: ['groups' => ['simple_calculator_request:write']],
            input: SimpleCalculatorRequest::class,
            output: SimpleCalculatorRequest::class,
            processor: SimpleCalculatorRequestProcessor::class
        )
    ]
)]
class SimpleCalculatorRequest
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['simple_calculator_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\NotNull]
    public int $firstOperand;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['simple_calculator_request:write'])]
    #[Assert\Type(type: 'integer')]
    public int $SecondOperand;

    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['simple_calculator_request:read'])]
    public int $result;

    public function process(): void
    {
        $this->result = (($this->firstOperand * $this->SecondOperand) * 0.005);
    }
}