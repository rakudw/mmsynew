<?php

namespace App\Models;

use App\Enums\BannerTypeEnum;
use App\Interfaces\CrudInterface;

/**
 * @property string $description
 * @property string $status
 * @property string $link
 */
class Faqs extends Base implements CrudInterface
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'answer',
        'status',
    ];

    public function getFormDesign(): object
    {
        return (object)[(object)[
                'type' => 'textarea',
                'label' => 'question',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The question of the faq.',
                'attributes' => (object)[
                    'name' => 'question',
                    'required' => 'required',
                    'autofocus' => 'autofocus',
                    'placeholder' => 'Faq question',
                ],
            ],
            (object)[
                'type' => 'textarea',
                'label' => 'answer',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The answer of the question.',
                'attributes' => (object)[
                    'name' => 'answer',
                    'required' => 'required',
                    'placeholder' => 'Question answer',
                ],
            ],
            (object)[
                'type' => 'select',
                'label' => 'Status',
                'width' => '12',
                'helpText' => 'Status of the Faq.',
                'attributes' => (object)[
                    'name' => 'status',
                    'required' => 'required',
                    'data-options' => 'csv:Active,Inactive',
                ],
            ],
            // Add more form fields as needed
        ];
    }

    public function getRequestValidator(): array
    {
        return [
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',
        ];
    }
}
