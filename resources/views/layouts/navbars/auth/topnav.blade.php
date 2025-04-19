@push('css')
<style>
    .navbar-search-block .input-group {
        width: 100%;
        min-width: 250px;
    }
    
    .navbar-search-block {
        width: auto;
        max-width: 400px;
        margin-right: 20px; 
    }
    
    .navbar-search-block .form-control {
        width: 100%; 
    }
    
    #navbar {
        overflow: visible
    }
    
    #searchSuggestions {
    background: linear-gradient(135deg,rgb(144, 153, 199) 0%,rgb(216, 118, 156) 100%) !important;
    
}


    #searchSuggestions .dropdown-item {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        white-space: normal; 
    } 
    
    #searchSuggestions .dropdown-item {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        white-space: normal;
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
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center w-100">
        <div class="d-flex align-items-center">
            <h4 class="font-weight-bolder text-white mb-0">{{ $title }}</h4>
        </div>
        <div class="d-flex align-items-center justify-content-end flex-grow-1" id="navbar">
            <div class="navbar-search-block me-3">
                <div class="input-group rounded-pill overflow-hidden">
                    <span class="input-group-text text-body bg-white border-0">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control border-0" id="searchInput" placeholder="Search here..." style="border-radius: 0;">
                </div>
                <div class="dropdown-menu" id="searchSuggestions" style="display: none; max-height: 400px; overflow-y: auto; padding: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border-radius: 10px; position: absolute; top: calc(100% + 10px); left: 0; width: 800px; z-index: 1050;">
                </div>
            </div>
            <ul class="navbar-nav d-flex flex-row align-items-center">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
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
                <li class="nav-item d-flex align-items-center">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white font-weight-bold px-2 py-1 m-0" style="text-decoration: none;">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Log out</span>
                        </button>
                    </form>
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

 // Prevent scroll events in the suggestions box from propagating to the page
 suggestionsBox.addEventListener('wheel', function(e) {
            // Check if the suggestions box is scrollable
            const isScrollable = this.scrollHeight > this.clientHeight;
            
            if (isScrollable) {
                // Check if we're trying to scroll past the top or bottom
                const isScrollingPastTop = this.scrollTop === 0 && e.deltaY < 0;
                const isScrollingPastBottom = 
                    this.scrollHeight - this.scrollTop <= this.clientHeight + 1 && e.deltaY > 0;
                
                // Only prevent default if we're not at the boundaries or trying to scroll within the box
                if (!isScrollingPastTop && !isScrollingPastBottom) {
                    e.stopPropagation();
                    e.preventDefault();
                    
                    // Manually handle the scroll
                    this.scrollTop += e.deltaY;
                }
            }
        }, { passive: false });
        
        // Function to extract only text from specific HTML tags
        function extractTextFromHtmlTags(html) {
            // Create a temporary DOM element
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html || '';
            
            // Get all text elements we want to keep
            const textElements = tempDiv.querySelectorAll('p, h1, h2, h3, h4, h5, h6, span, a, li, td, th, div, label, button');
            
            // Extract text from these elements
            let extractedText = '';
            textElements.forEach(element => {
                // Get direct text content of this element (not including child elements)
                const directText = Array.from(element.childNodes)
                    .filter(node => node.nodeType === Node.TEXT_NODE)
                    .map(node => node.textContent.trim())
                    .join(' ');
                    
                if (directText && directText.trim().length > 0) {
                    extractedText += directText + ' ';
                }
            });
            
            // If no text elements found, try to get any visible text
            if (!extractedText.trim()) {
                extractedText = tempDiv.textContent || tempDiv.innerText || '';
            }
            
            return extractedText.trim();
        }
        
        // Function to get only 3 words around the matching text
        function getContextAroundMatch(text, query) {
            if (!text || !query) return '';
            
            const lowerText = text.toLowerCase();
            const lowerQuery = query.toLowerCase();
            const matchIndex = lowerText.indexOf(lowerQuery);
            
            if (matchIndex === -1) return text.substring(0, 50) + '...';
            
            // Find the start of the current word
            let startIndex = matchIndex;
            while (startIndex > 0 && !/\s/.test(text[startIndex - 1])) {
                startIndex--;
            }
            
            // Go back 3 words
            let wordCount = 0;
            let contextStart = startIndex;
            while (contextStart > 0 && wordCount < 3) {
                contextStart--;
                if (contextStart === 0 || (/\s/.test(text[contextStart]) && !/\s/.test(text[contextStart + 1]))) {
                    wordCount++;
                }
            }
            
            // Find the end of the current word
            let endIndex = matchIndex + query.length;
            while (endIndex < text.length && !/\s/.test(text[endIndex])) {
                endIndex++;
            }
            
            // Go forward 3 words
            wordCount = 0;
            let contextEnd = endIndex;
            while (contextEnd < text.length && wordCount < 3) {
                if (contextEnd === text.length - 1 || (/\s/.test(text[contextEnd]) && !/\s/.test(text[contextEnd + 1]))) {
                    wordCount++;
                }
                contextEnd++;
            }
            
            // Add ellipsis if needed
            const prefix = contextStart > 0 ? '...' : '';
            const suffix = contextEnd < text.length ? '...' : '';
            
            return prefix + text.substring(contextStart, contextEnd).trim() + suffix;
        }
        
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
                            
                            // Extract only text from HTML tags
                            let sanitizedContext = extractTextFromHtmlTags(result.context);
                            
                            // Remove PHP code and other unwanted content
                            sanitizedContext = sanitizedContext
                                .replace(/\<\?php[\s\S]*?\?\>/g, '') // Remove PHP code blocks
                                .replace(/\{\{[\s\S]*?\}\}/g, '')    // Remove Blade expressions
                                .replace(/\@[a-zA-Z]+[\s\S]*?\@end[a-zA-Z]+/g, '') // Remove Blade directives
                                .replace(/\@[a-zA-Z]+\([\s\S]*?\)/g, '') // Remove Blade function calls
                                .replace(/\$[a-zA-Z_][a-zA-Z0-9_]*/g, '') // Remove PHP variables
                                .replace(/\s+/g, ' ')               // Normalize whitespace
                                .trim();
                            
                            // Get only 3 words around the matching text
                            sanitizedContext = getContextAroundMatch(sanitizedContext, query);
                            
                            // If context is empty after sanitization, provide a fallback
                            if (!sanitizedContext) {
                                sanitizedContext = 'View this page for more information';
                            }
                            
                            // Highlight the query in the sanitized context
                            if (sanitizedContext && query.length > 1) {
                                // Use a regex with 'gi' flags for global, case-insensitive matching
                                const regex = new RegExp(query, 'gi');
                                sanitizedContext = sanitizedContext.replace(regex, match => `<strong class="text-primary">${match}</strong>`);
                            }
                            
                            // Create a sanitized title
                            let sanitizedTitle = extractTextFromHtmlTags(result.title);
                            sanitizedTitle = sanitizedTitle || 'Untitled';
                            
                            // Trim title if too long
                            if (sanitizedTitle.length > 50) {
                                sanitizedTitle = sanitizedTitle.substring(0, 50) + '...';
                            }
                            
                            suggestionsBox.innerHTML += `
                                <a class="dropdown-item" href="${result.url}">
                                    <i class="fas fa-file-alt mr-2"></i>
                                    ${sanitizedTitle}
                                    <br>
                                    <small class="text-muted ml-2">${sanitizedContext}</small>
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
                .catch(error => {
                    console.error("Search error:", error);
                    suggestionsBox.innerHTML = `
                        <span class="dropdown-item text-danger">
                            Error fetching results: ${error.message}
                        </span>
                    `;
                    suggestionsBox.style.display = 'block';
                });
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