<?php

namespace App\Models;

use App\Interfaces\CrudInterface;

/**
 * @property string $description
 * @property string $status
 * @property string $link
 */
class Usefultip extends Base implements CrudInterface
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'status',
        'link',
    ];

    public function getFormDesign(): object
    {
        return (object)[(object)[
                'type' => 'textarea',
                'label' => 'Description',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The description of the tip.',
                'attributes' => (object)[
                    'name' => 'description',
                    'required' => 'required',
                    'placeholder' => 'Tip description',
                ],
            ],
            (object)[
                'type' => 'select',
                'label' => 'Status',
                'width' => '12',
                'helpText' => 'Status of the Tip.',
                'attributes' => (object)[
                    'name' => 'status',
                    'required' => 'required',
                    'data-options' => 'csv:Active,Inactive',
                ],
            ],
            (object)[
                'type' => 'textarea',
                'label' => 'Link',
                'width' => '12',
                'helpText' => 'Link associated with the Tip.',
                'attributes' => (object)[
                    'name' => 'link',
                    'required' => 'required',
                ],
            ],
            // Add more form fields as needed
        ];
    }

    public function getRequestValidator(): array
    {
        return [
            'description' => 'required',
            'status' => 'required',
        ];
    }

}

