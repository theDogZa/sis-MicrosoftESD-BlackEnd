<div id="page-header-search" class="overlay-header">
    <div class="content-header content-header-fullrow">
        <form action="/dashboard" method="POST">
            @csrf
            <div class="input-group">
                <div class="input-group-prepend">
                    <!-- Close Search Section -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                        <i class="fa fa-times"></i>
                    </button>
                    <!-- END Close Search Section -->
                </div>
                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
   </div>
</div>