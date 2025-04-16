<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SearchController extends Controller
{
    private $searchPaths = [
        'views' => 'views/*.blade.php',
        'pages' => 'views/pages/*.blade.php',
        'admin' => 'views/admin/*.blade.php',
        'auth' => 'views/auth/*.blade.php',
        'cashier' => 'views/cashier/*.blade.php',
        'components' => 'views/components/*.blade.php',
        'drugs' => 'views/drugs/*.blade.php',
        'expiry' => 'views/expiry/*.blade.php',
        'medical-assistant' => 'views/medical-assistant/*.blade.php',
        'pharmacist' => 'views/pharmacist/*.blade.php',
        'roles' => 'views/roles/*.blade.php',
        'sales' => 'views/sales/*.blade.php',
        'stock' => 'views/stock/*.blade.php',
        'suppliers' => 'views/suppliers/*.blade.php'
    ];

    private $routeMap = [
        'dashboard' => 'dashboard',
        'drugs.index' => 'drugs.index',
        'suppliers.index' => 'suppliers.index',
        'stock.index' => 'stock.index',
        'stock.show' => 'stock.show',
        'receive.stock' => 'receive.stock',
        'stock.view' => 'stock.view',
        'approve.stock.orders' => 'approve.stock.orders'
        // Add more route mappings as needed
    ];

    public function search(Request $request)
    {
        $query = strtolower($request->input('query'));
        $results = [];

        foreach ($this->searchPaths as $type => $path) {
            $files = File::glob(resource_path($path));
            
            foreach ($files as $file) {
                $content = file_get_contents($file);
                
                // Extract content within <section class="content"> tags
                if (preg_match('/<section class="content">(.*?)<\/section>/s', $content, $matches)) {
                    $text = strtolower(strip_tags($matches[1]));
                    
                    if (strpos($text, $query) !== false) {
                        $fileName = basename($file, '.blade.php');
                        
                        // Use route name if mapped, otherwise fallback to file path
                        $url = isset($this->routeMap[$fileName]) 
                            ? route($this->routeMap[$fileName])
                            : url(str_replace('.', '/', $fileName));

                        $results[] = [
                            'title' => ucwords(str_replace('-', ' ', $fileName)),
                            'url' => $url,
                            'context' => $this->getMatchContext($text, $query),
                            'section' => ucfirst($type)
                        ];
                    }
                }
            }
        }
        
        return response()->json($results);
    }

    private function getMatchContext($text, $query, $length = 50)
    {
        $position = strpos($text, $query);
        $start = max(0, $position - $length/2);
        return '...' . substr($text, $start, $length) . '...';
    }
}
