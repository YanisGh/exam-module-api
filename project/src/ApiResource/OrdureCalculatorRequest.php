<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\SimpleCalculatorRequestAction;
use ApiPlatform\OpenApi\Model;
use App\State\CalculOrderReqProc;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/Ordures",
            openapi: new Model\Operation(
                summary: 'Calcul taxes ordures',
                description: 'Permet de calculer le montant de la taxe des Ordures Menageres',
            ),
            //controller: SimpleCalculatorRequestAction::class,
            normalizationContext: ['groups' => ['simple_calculator_request:read']],
            denormalizationContext: ['groups' => ['simple_calculator_request:write']],
            input: OrdureCalculatorRequest::class,
            output: OrdureCalculatorRequest::class,
            processor: CalculOrderReqProc::class
        )
    ]
)]
class OrdureCalculatorRequest
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
    #[Groups(['simple_calculator_request:read'])]
    public int $result;

    public function process(): void
    {
        $this->result = (($this->firstOperand / 2) * 0.0937);
    }
}