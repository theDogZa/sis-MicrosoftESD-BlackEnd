<div class="btn-group" role="group">
    <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user d-sm-none"></i>
        <span class="d-none d-sm-inline-block">{{auth()->user()->username}}</span>
        <i class="fa fa-angle-down ml-5"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
        <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">User</h5>
        <a class="dropdown-item" href="{{ route('profiles.index') }}">
            <i class="si si-user mr-5"></i> Profile
        </a>
        <a class="dropdown-item" href="{{ route('change_passwords.index') }}">
            <i class="si si-key mr-5"></i> Change Password
        </a>
        {{-- 
        <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
            <span><i class="si si-envelope-open mr-5"></i> Inbox</span>
            <span class="badge badge-primary">3</span>
        </a>
        <a class="dropdown-item" href="javascript:void(0)">
            <i class="si si-note mr-5"></i> Invoices
        </a>
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
            <i class="si si-wrench mr-5"></i> Settings
        </a> --}}


        {{-- <div class="dropdown-divider"></div> --}}
        <a class="dropdown-item" href="/logout">
            <i class="si si-logout mr-5"></i> Sign Out
        </a>
    </div>
</div>