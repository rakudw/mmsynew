<?php

namespace App\Models;

use App\Interfaces\CrudInterface;

/**
 * @property string $title
 * @property string $description
 * @property string $image_path
 * @property string $status
 * @property int $year
 * @property string $link
 */
class Banner extends Base implements CrudInterface
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
        'minister_image',
        'minister_name',
        'minister_designation',
        'status',
        'year',
        'type',
        'link',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Enum::class, 'type_id');
    }

    /**
     * Get class enum for the banner type
     *
     * @return BannerTypeEnum
     */
    public function getBannerTypeEnumAttribute(): BannerTypeEnum
    {
        return BannerTypeEnum::fromId($this->type_id);
    }

    public function getFormDesign(): object
    {
        return (object)[(object)[
                'type' => 'textarea',
                'label' => 'Banner Title',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The title of the banner.',
                'attributes' => (object)[
                    'name' => 'title',
                    'required' => 'required',
                    'autofocus' => 'autofocus',
                    'placeholder' => 'Banner title',
                ],
            ],(object)[
                'type' => 'textarea',
                'label' => 'Description',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The description of the banner.',
                'attributes' => (object)[
                    'name' => 'description',
                    'required' => 'required',
                    'placeholder' => 'Banner description',
                ],
            ],
            (object)[
                'type' => 'select',
                'label' => 'Status',
                'width' => '12',
                'helpText' => 'Status of the banner.',
                'attributes' => (object)[
                    'name' => 'status',
                    'required' => 'required',
                    'data-options' => 'csv:Active,Inactive',
                ],
            ],
            (object)[
                'type' => 'input',
                'label' => 'Year',
                'width' => '12',
                'helpText' => 'Year of the banner.',
                'attributes' => (object)[
                    'name' => 'year',
                    'type' => 'number',
                    'required' => 'required',
                    'min' => 2000, // Minimum year
                    'max' => date('Y'), // Maximum current year
                ],
            ],
            (object)[
                'type' => 'select',
                'label' => 'Type',
                'width' => '12',
                'helpText' => 'Type of the banner.',
                'attributes' => (object)[
                    'data-options' => 'csv:Front,Back',
                    'name' => 'type',
                    'required' => 'required'
                ],
            ],
            (object)[
                'type' => 'textarea',
                'label' => 'Link',
                'width' => '12',
                'helpText' => 'Link associated with the banner.',
                'attributes' => (object)[
                    'name' => 'link',
                ],
            ],(object)[
                'type' => 'input',
                'label' => 'Image',
                'width' => '12',
                'helpText' => 'Image associated with the banner.',
                'attributes' => (object)[
                    'name' => 'image',
                    'type' => 'file', // This indicates it's a file input
                    'required' => 'required',
                    'placeholder' => 'Banner image',
                ],
            ],
            (object)[
                'type' => 'input',
                'label' => 'Minister Image',
                'width' => '12',
                'helpText' => 'Image associated with the Minister.',
                'attributes' => (object)[
                    'name' => 'minister_image',
                    'type' => 'file', // This indicates it's a file input
                    'placeholder' => 'Minister image',
                ],
            ],(object)[
                'type' => 'textarea',
                'label' => 'Minister Name',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'The name of the Minister.',
                'attributes' => (object)[
                    'name' => 'minister_name',
                    'required' => 'required',
                    'placeholder' => 'Minister name',
                ],
            ],(object)[
                'type' => 'textarea',
                'label' => 'Minister Designation',
                'width' => '12',
                'noLabel' => true,
                'helpText' => 'Name of the Minister Designation.',
                'attributes' => (object)[
                    'name' => 'minister_designation',
                    'required' => 'required',
                    'placeholder' => 'Minister Designation',
                ],
            ]
            // Add more form fields as needed
        ];
    }

    public function getRequestValidator(): array
    {
        return [
            'title' => 'required|max:511',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'minister_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'minister_name' => 'required',
            'minister_designation' => 'required',
            'status' => 'required',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'type' => 'required',
        ];
    }

    

    // Add relationships, accessors, mutators, and other methods as needed
}
