<?php

namespace App\View\Components;

use App\Models\Application;
use App\Models\Form as FormModel;
use App\Models\FormDesign;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Form extends Component
{
    public Application $application;

    public Collection $formDesigns;

    public FormDesign $design;

    public FormModel $form;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(FormModel $form, FormDesign $design, Application $application, Collection $formDesigns)
    {
        $this->form = $form;
        $this->design = $design;
        $this->application = $application;
        $this->formDesigns = $formDesigns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        try {
            return view('components.form', ['view' => $this]);
        } catch(Exception $ex) {
            Log::error($ex->getMessage(), ['exception' => $ex]);
        }
    }

    public function evaluate($code) {
        $data = $this->application->data;
        $result = null;
        eval('$result = ' . $code . ';');
        return $result;
    }
}
