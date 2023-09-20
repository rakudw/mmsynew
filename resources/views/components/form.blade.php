<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">{{ $form->name }}</h6>
        </div>
    </div>
    <div class="card-body px-0 pb-2">
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-3" role="tablist">
                @foreach ($formDesigns as $formDesign)
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 {{ $design->id == $formDesign->id ? 'active' : '' }}"
                            href="{{ $design->id == $formDesign->id? '#': route('application.' . ($application->id > 0 ? 'edit' : 'create'), ['application' => $application->id, 'form' => $application->id > 0 ? null : $form->id, 'formDesignId' => $formDesign->id]) }}"
                            role="tab" aria-selected="{{ $design->id == $formDesign->id ? 'true' : 'false' }}">
                            <span class="material-icons align-middle mb-1">
                                badge
                            </span>
                            @if($design->id == $formDesign->id)
                                <strong>{{ $formDesign->name }}</strong>
                            @else
                                {{ $formDesign->name }}
                            @endif
                        </a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" href="{{ route('application.documents', ['application' => $application->id ?? 1]) }}" aria-selected="false">
                        <span class="material-icons align-middle mb-1">
                            laptop
                        </span>
                        Documents
                    </a>
                </li>
            </ul>
        </div>
        <form method="post" action="{{ route('application.store', ['form' => $form->id,'formDesign' => $design->id,'application' => $application->id]) }}">
            @csrf
            @foreach ($design->design as $element)
                @if (!property_exists($element, 'renderIf') || $view->evaluate($element->renderIf))
                    <x-element :application="$application" :design="$design" :form="$form" :element="$element" />
                @endif
            @endforeach

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                @if($formDesigns->last()->id == $design->id)
                                    Save &amp; Upload Documents
                                @else
                                    Save &amp; Goto Next Step
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
