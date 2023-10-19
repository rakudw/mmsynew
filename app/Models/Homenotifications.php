<?php

namespace App\Models;

use App\Interfaces\CrudInterface;

/**
 * @property string $description
 * @property string $status
 * @property string $link
 */
class Homenotifications extends Base implements CrudInterface
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'file',
        'link',
    ];

    public function getFormDesign(): object
    {
        return (object)[(object)[
                'type' => 'textarea',
                'label' => 'Title',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The title of the notification.',
                'attributes' => (object)[
                    'name' => 'title',
                    'required' => 'required',
                    'autofocus' => 'autofocus',
                    'placeholder' => 'Notification title',
                ],
            ],
            (object)[
                'type' => 'textarea',
                'label' => 'Description',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The description of the notification.',
                'attributes' => (object)[
                    'name' => 'description',
                    'required' => 'required',
                    'placeholder' => 'Notification description',
                ],
            ],
            (object)[
                'type' => 'select',
                'label' => 'Status',
                'width' => '12',
                'helpText' => 'Status of the notification.',
                'attributes' => (object)[
                    'name' => 'status',
                    'required' => 'required',
                    'data-options' => 'csv:Active,Inactive',
                ],
            ],
            (object)[
                'type' => 'input',
                'label' => 'File',
                'width' => '12',
                'helpText' => 'Any File Image/Video associated with story',
                'attributes' => (object)[
                    'name' => 'file',
                    'type' => 'file', // This indicates it's a file input
                    'placeholder' => 'pdf only',
                ],
            ],
            (object)[
                'type' => 'textarea',
                'label' => 'Link',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The Link of the notification.',
                'attributes' => (object)[
                    'name' => 'link',
                    'placeholder' => 'Notification Link',
                ],
            ],
            // Add more form fields as needed
        ];
    }

    public function getRequestValidator(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            // 'file' => 'required|mimetypes:application/pdf|max:2048',
            'status' => 'required',
        ];
    }
}
