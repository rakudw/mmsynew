<?php

namespace App\Models;

use App\Enums\BannerTypeEnum;
use App\Interfaces\CrudInterface;

/**
 * @property string $description
 * @property string $status
 * @property string $link
 */
class Dlcmeeting extends Base implements CrudInterface
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'meeting_id',
        'status',
        'link',
    ];

    public function getFormDesign(): object
    {
        return (object)[(object)[
                'type' => 'textarea',
                'label' => 'Title',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The Title of the Meeting.',
                'attributes' => (object)[
                    'name' => 'title',
                    'required' => 'required',
                    'placeholder' => 'Meeting title',
                ],
            ],(object)[
                'type' => 'textarea',
                'label' => 'Description',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The description of the meeting.',
                'attributes' => (object)[
                    'name' => 'description',
                    'required' => 'required',
                    'placeholder' => 'Meeting description',
                ],
            ],
            (object)[
                'type' => 'select',
                'label' => 'SelectMeeting',
                'width' => '12',
                'helpText' => 'Select Meeting',
                'attributes' => (object)[
                    'data-options' => 'dbase:meeting(id,title)',
                    'name' => 'meeting_id',
                    'required' => 'required'
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
            ],(object)[
                'type' => 'input',
                'label' => 'Image',
                'width' => '12',
                'helpText' => 'Image associated with the meeting.',
                'attributes' => (object)[
                    'name' => 'image',
                    'type' => 'file', // This indicates it's a file input
                    'required' => 'required',
                    'placeholder' => 'Banner image',
                ],
            ],
            // Add more form fields as needed
        ];
    }

    public function getRequestValidator(): array
    {
        return [
            'title' => 'required|max:511',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
            'meeting_id' => 'required|numeric|exists:App\\Models\\Meeting,id',
            'link' => 'required',
        ];
    }

}

