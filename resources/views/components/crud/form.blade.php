<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">{{ ($model->id ? 'Update ' : 'Create ') . $pageVars['modelName'] }}</h6>
        </div>
    </div>
    <div class="card-body pb-2">
        <form method="post" action="{{ $model->id ? route('crud.update', ['class' => $pageVars['class'], 'id' => $model->id]) : route('crud.store', ['class' => $pageVars['class']]) }}" enctype="multipart/form-data">
            @csrf
            @foreach ($model->getFormDesign() as $element)
                @if (!property_exists($element, 'renderIf') || $view->evaluate($element->renderIf))
                    <x-crud.element :design="$model->getFormDesign()" :element="$element" :model="$model" />
                @endif
            @endforeach

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                {{ ($model->id ? 'Update ' : 'Create ') . $pageVars['modelName'] }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
