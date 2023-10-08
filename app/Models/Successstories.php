<?php

namespace App\Models;

use App\Enums\BannerTypeEnum;
use App\Interfaces\CrudInterface;

/**
 * @property string $description
 * @property string $status
 * @property string $link
 */
class Successstories extends Base implements CrudInterface
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
    ];

    public function getFormDesign(): object
    {
        return (object)[(object)[
                'type' => 'textarea',
                'label' => 'Title',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The title of the story.',
                'attributes' => (object)[
                    'name' => 'title',
                    'required' => 'required',
                    'autofocus' => 'autofocus',
                    'placeholder' => 'Story title',
                ],
            ],
            (object)[
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
                'type' => 'input',
                'label' => 'File',
                'width' => '12',
                'helpText' => 'Any File Image/Video associated with story',
                'attributes' => (object)[
                    'name' => 'file',
                    'type' => 'file', // This indicates it's a file input
                    'placeholder' => 'Image/Video',
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
            'file' => 'required|mimetypes:image/*,video/*|max:20480',
            'status' => 'required',
        ];
    }
}
