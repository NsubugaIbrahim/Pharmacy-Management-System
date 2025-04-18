@push('css')
<style>
   /* Ensure the search input has enough width */
    .navbar-search-block .input-group {
        width: 100%; /* Make it take full width of its container */
        min-width: 250px; /* Ensure a minimum width */
    }
    
    /* Fix the container width */
    .navbar-search-block {
        width: auto; /* Let it grow based on content */
        max-width: 400px; /* Maximum width - adjust as needed */
        margin-right: 20px; /* Add some space on the right */
    }
    
    /* Ensure the form control (input) isn't constrained */
    .navbar-search-block .form-control {
        width: 100%; /* Take full width of input-group */
    }
    
    /* Fix any overflow issues */
    #navbar {
        overflow: visible !important; /* Ensure dropdowns aren't cut off */
    }
    
    /* Rest of your existing styles */
    #searchSuggestions .dropdown-item {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        white-space: normal; /* Allow text to wrap */
    }
    
    
    /* Rest of your existing styles */
    #searchSuggestions .dropdown-item {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        white-space: normal; /* Allow text to wrap */
    }
    
    #searchSuggestions .dropdown-item:last-child {
        border-bottom: none;
    }
    
    #searchSuggestions .dropdown-item:hover {
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    #searchSuggestions .dropdown-item i {
        margin-right: 10px;
        color: #5e72e4;
    }
    
    #searchSuggestions .dropdown-item small {
        display: block;
        margin-top: 5px;
        color: #8898aa;
    }
</style>
@endpush



<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}" id="navbarBlur"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            {{-- <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
            </ol> --}}
            <h4 class="font-weight-bolder text-white mb-0">{{ $title }}</h4>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2" id="navbar">
            <div class="d-flex align-items-center navbar-search-block" style="margin-left: 100px !important;">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Search here...">
                    <div class="dropdown-menu" id="searchSuggestions" style="display: none; max-height: 400px; overflow-y: auto; padding: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border-radius: 10px; position: absolute; top: calc(100% + 10px); left: 0; width: 100%; z-index: 1050; width:600px;"></div>
                </div>
            </div>
            
            <ul class="navbar-nav  justify-content-end" style="margin-left: 250px !important;">
                <li class="nav-item d-flex align-items-center">
                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-white font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Log out</span>
                        </a>
                    </form>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="./img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="./img/small-logos/logo-spotify.svg"
                                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New album</span> by Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Payment successfully completed
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('searchSuggestions');
    
    if (!searchInput || !suggestionsBox) {
        console.error("Search elements not found in the DOM");
        return;
    }
    
    console.log("Search elements initialized");
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        console.log("Search query:", query);
        
        if (query.length < 2) {
            suggestionsBox.style.display = 'none';
            return;
        }
        
        // Make AJAX call to search endpoint
        console.log("Fetching search results for:", query);
        
        fetch('/api/search?query=' + encodeURIComponent(query))
            .then(response => {
                console.log("Search response status:", response.status);
                // Log the raw response for debugging
                response.clone().text().then(text => {
                    console.log("Raw response:", text);
                });
                
                if (!response.ok) {
                    throw new Error('Server returned ' + response.status);
                }
                return response.json();
            })
            .then(results => {
    console.log("Search results:", results);
    
    if (results && results.length > 0) {
        suggestionsBox.innerHTML = '';
        
        results.forEach(result => {
            // Get the query from the search input
            const query = searchInput.value.toLowerCase();
            
            // Highlight the query in the context
            let context = result.context;
            if (context && query.length > 1) {
                // Use a regex with 'gi' flags for global, case-insensitive matching
                const regex = new RegExp(query, 'gi');
                context = context.replace(regex, match => `<strong class="text-primary">${match}</strong>`);
            }
            
            suggestionsBox.innerHTML += `
                <a class="dropdown-item" href="${result.url}">
                    <i class="fas fa-file-alt mr-2"></i>
                    ${result.title}
                    <small class="text-muted ml-2">${context}</small>
                </a>
            `;
        });
        
        suggestionsBox.style.display = 'block';
    } else {
        suggestionsBox.innerHTML = `
            <span class="dropdown-item text-muted">
                No results found for "${searchInput.value}"
            </span>
        `;
        suggestionsBox.style.display = 'block';
    }
})

    });
    
    // Close suggestions on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-search-block')) {
            suggestionsBox.style.display = 'none';
        }
    });
});

</script>
@endpush
