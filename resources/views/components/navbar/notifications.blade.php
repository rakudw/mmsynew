@props(['user'])
@if($user->unreadNotifications && $user->unreadNotifications->count() >=1)
    <li class="nav-item dropdown pe-2 d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body pt-3 ms-2 position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="material-icons cursor-pointer">notifications</i>
            <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                <span class="small">{{ $user->unreadNotifications->count() ?? '' }}</span>
                <span class="visually-hidden">unread notifications</span>
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
            @foreach($user->unreadNotifications as $notification)
                <li class="@if($loop->last) mb-0 @else mb-2 @endif">
                    <a class="dropdown-item border-radius-md align-self-center" href="{{ $notification->data['link'] }}">
                        <div class="d-flex align-items-center py-1">
                            <img src="https://icon-library.com/images/icon-for-apps/icon-for-apps-17.jpg" class="avatar avatar-sm flex-shrink-0" alt="">
                            <div class="flex-grow-1 justify-content-center ps-3">
                                <h6 class="text-sm @if($notification->read_at==null) font-weight-bold @else font-weight-normal @endif mb-1">
                                    {{ $notification->data['title'] ?? '' }}
                                </h6>
                                <p class="text-xs text-secondary mb-0">
                                    <i class="fa fa-clock me-1" title="mark as read"></i>
                                    {!! $notification->data['description'] ?? '' !!}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex w-100 justify-content-between pt-2">
                            <h6 class="d-flex w-100 font-weight-lighter justify-content-end align-items-center" onclick="event.preventDefault(); document.getElementById('delete-notification').submit();"><i class="fas fa-trash-alt" title="Delete Notification" ></i><small class="ps-1">Delete Notification</small></h6>
                            <h6 class="d-flex w-100 font-weight-lighter justify-content-end align-items-center" onclick="event.preventDefault(); document.getElementById('mark-as-read').submit();">
                                <i class="fas fa-check-circle" title="Mark as Read"></i><small class="ps-1">Mark as Read</small>
                            </h6>
                        </div>
                    </a>
                </li>
                <form id="mark-as-read" action="{{ route('notification.read', $notification->id) }}" method="POST" style="display: none;">
                    @csrf @method('PATCH')
                </form>
                <form id="delete-notification" action="{{ route('notification.destroy', $notification->id) }}" method="POST" style="display: none;">
                    @csrf @method('DELETE')
                </form>
            @endforeach
        </ul>
    </li>
@endif
