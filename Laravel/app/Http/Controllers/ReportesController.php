<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $idEmpresa = session('empresa_id');
        
        if (!$idEmpresa) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }
        
        // Obtener período de filtrado (por defecto últimos 30 días)
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(30);
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
        }
        
        // Obtener estadísticas de métricas
        $stats = $this->getMetrics($idEmpresa, $startDate, $endDate);
        
        // Obtener datos para gráficos
        $salesChartData = $this->getSalesChartData($idEmpresa, $startDate, $endDate);
        $clientsChartData = $this->getClientsChartData($idEmpresa, $startDate, $endDate);
        $salesDistributionData = $this->getSalesDistributionData($idEmpresa, $startDate, $endDate);
        $leadsStatusData = $this->getLeadsStatusData($idEmpresa, $startDate, $endDate);
        
        // Obtener productos con mejor rendimiento
        $topProducts = $this->getTopProducts($idEmpresa, $startDate, $endDate);
        
        return view('reportes.index', compact(
            'stats',
            'salesChartData',
            'clientsChartData', 
            'salesDistributionData',
            'leadsStatusData',
            'topProducts',
            'startDate',
            'endDate'
        ));
    }
    
    private function getMetrics($idEmpresa, $startDate, $endDate)
    {
        // Añadir depuración para verificar fechas y empresa
        \Illuminate\Support\Facades\Log::info("Obteniendo métricas", [
            'idEmpresa' => $idEmpresa,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s')
        ]);
        
        // Total de clientes actuales
        $totalClients = DB::table('Clients')
            ->where('idEmpresa', $idEmpresa)
            ->count();
            
        // Clientes del período anterior para comparación
        $previousPeriodDays = $endDate->diffInDays($startDate);
        $previousPeriodStart = (clone $startDate)->subDays($previousPeriodDays);
        $previousPeriodEnd = (clone $startDate)->subDay();
        
        $previousPeriodClients = DB::table('Clients')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$previousPeriodStart, $previousPeriodEnd])
            ->count();
            
        $currentPeriodClients = DB::table('Clients')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$startDate, $endDate])
            ->count();
            
        $clientsGrowth = $previousPeriodClients > 0 
            ? round((($currentPeriodClients - $previousPeriodClients) / $previousPeriodClients) * 100, 1)
            : ($currentPeriodClients > 0 ? 100 : 0);

        // Verificar estados de ventas disponibles (para depuración)
        $availableStates = DB::table('SalesProposals')
            ->select('State')
            ->where('idEmpresa', $idEmpresa)
            ->distinct()
            ->get()
            ->pluck('State')
            ->toArray();
            
        \Illuminate\Support\Facades\Log::info("Estados de ventas disponibles:", $availableStates);
        
        // Total de ventas (completadas) - Modificado para capturar todas las ventas confirmadas
        // Usamos un where más inclusivo y añadimos depuración
        $salesQuery = DB::table('SalesProposals')
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where(function($query) {
                $query->where('SalesProposals.State', 'completed')
                      ->orWhere('SalesProposals.State', 'Completed')
                      ->orWhere('SalesProposals.State', 'confirmado')
                      ->orWhere('SalesProposals.State', 'Confirmado');
            })
            ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID');
            
        // Añadir depuración para ver la consulta SQL
        \Illuminate\Support\Facades\Log::info("Consulta SQL para ventas: " . $salesQuery->toSql(), $salesQuery->getBindings());
        
        $totalSales = $salesQuery->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
        
        \Illuminate\Support\Facades\Log::info("Total de ventas calculado: " . $totalSales);
        
        // Ventas del período anterior para comparación con la misma consulta mejorada
        $previousPeriodSales = DB::table('SalesProposals')
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where(function($query) {
                $query->where('SalesProposals.State', 'completed')
                      ->orWhere('SalesProposals.State', 'Completed')
                      ->orWhere('SalesProposals.State', 'confirmado')
                      ->orWhere('SalesProposals.State', 'Confirmado');
            })
            ->whereBetween('SalesProposals.CreatedAt', [$previousPeriodStart, $previousPeriodEnd])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
            
        $salesGrowth = $previousPeriodSales > 0 
            ? round((($totalSales - $previousPeriodSales) / $previousPeriodSales) * 100, 1)
            : ($totalSales > 0 ? 100 : 0);
            
        // Proyectos activos
        $totalProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->where('Status', 'In Progress')
            ->count();
            
        // Proyectos creados en este período
        $currentPeriodProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$startDate, $endDate])
            ->count();
            
        // Proyectos creados en el período anterior
        $previousPeriodProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$previousPeriodStart, $previousPeriodEnd])
            ->count();
            
        $projectsGrowth = $previousPeriodProjects > 0 
            ? round((($currentPeriodProjects - $previousPeriodProjects) / $previousPeriodProjects) * 100, 1)
            : ($currentPeriodProjects > 0 ? 100 : 0);
            
        // Leads activos
        $activeLeads = DB::table('Leads')
            ->where('idEmpresa', $idEmpresa)
            ->whereIn('Status', ['New', 'In Progress', 'Qualified'])
            ->count();
            
        // Leads creados en este período
        $currentPeriodLeads = DB::table('Leads')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$startDate, $endDate])
            ->count();
            
        // Leads creados en el período anterior
        $previousPeriodLeads = DB::table('Leads')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$previousPeriodStart, $previousPeriodEnd])
            ->count();
            
        $leadsGrowth = $previousPeriodLeads > 0 
            ? round((($currentPeriodLeads - $previousPeriodLeads) / $previousPeriodLeads) * 100, 1)
            : ($currentPeriodLeads > 0 ? 100 : 0);
        
        return [
            'clients' => [
                'total' => $totalClients,
                'new' => $currentPeriodClients,
                'growth' => $clientsGrowth
            ],
            'sales' => [
                'total' => $totalSales,
                'growth' => $salesGrowth
            ],
            'projects' => [
                'total' => $totalProjects,
                'new' => $currentPeriodProjects,
                'growth' => $projectsGrowth
            ],
            'leads' => [
                'total' => $activeLeads,
                'new' => $currentPeriodLeads,
                'growth' => $leadsGrowth
            ]
        ];
    }
    
    private function getSalesChartData($idEmpresa, $startDate, $endDate)
    {
        // Añadir depuración
        \Illuminate\Support\Facades\Log::info("Obteniendo datos para gráfico de ventas", [
            'idEmpresa' => $idEmpresa,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s')
        ]);

        // Determinar intervalo basado en la diferencia de días
        $diffDays = $endDate->diffInDays($startDate);
        
        if ($diffDays <= 31) {
            // Datos diarios para períodos cortos
            $salesByPeriod = DB::table('SalesProposals')
                ->select(DB::raw('DATE(CreatedAt) as period'), DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('SalesProposals.State', 'completed')
                          ->orWhere('SalesProposals.State', 'Completed')
                          ->orWhere('SalesProposals.State', 'confirmado')
                          ->orWhere('SalesProposals.State', 'Confirmado');
                })
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->groupBy('period')
                ->orderBy('period')
                ->get();
                
            \Illuminate\Support\Facades\Log::info("Ventas diarias encontradas:", [
                'count' => $salesByPeriod->count(),
                'data' => $salesByPeriod
            ]);
                
            $labels = [];
            $data = [];
            
            // Crear array de fechas para incluir días sin ventas
            $currentDate = clone $startDate;
            while ($currentDate <= $endDate) {
                $dateStr = $currentDate->format('Y-m-d');
                $labels[] = $currentDate->format('d M');
                
                $found = false;
                foreach ($salesByPeriod as $sale) {
                    if ($sale->period == $dateStr) {
                        $data[] = $sale->total;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $data[] = 0;
                }
                
                $currentDate->addDay();
            }
        } else {
            // Datos mensuales para períodos largos
            $salesByPeriod = DB::table('SalesProposals')
                ->select(DB::raw('YEAR(CreatedAt) as year, MONTH(CreatedAt) as month'), DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('SalesProposals.State', 'completed')
                          ->orWhere('SalesProposals.State', 'Completed')
                          ->orWhere('SalesProposals.State', 'confirmado')
                          ->orWhere('SalesProposals.State', 'Confirmado');
                })
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
                
            \Illuminate\Support\Facades\Log::info("Ventas mensuales encontradas:", [
                'count' => $salesByPeriod->count(),
                'data' => $salesByPeriod
            ]);
                
            $labels = [];
            $data = [];
            
            // Crear array de meses para incluir meses sin ventas
            $currentDate = clone $startDate->startOfMonth();
            $endMonthDate = clone $endDate->endOfMonth();
            
            while ($currentDate <= $endMonthDate) {
                $year = $currentDate->year;
                $month = $currentDate->month;
                $labels[] = $currentDate->format('M Y');
                
                $found = false;
                foreach ($salesByPeriod as $sale) {
                    if ($sale->year == $year && $sale->month == $month) {
                        $data[] = $sale->total;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $data[] = 0;
                }
                
                $currentDate->addMonth();
            }
        }
        
        $result = [
            'labels' => $labels,
            'data' => $data
        ];
        
        \Illuminate\Support\Facades\Log::info("Datos para gráfico de ventas preparados", $result);
        
        return $result;
    }
    
    private function getClientsChartData($idEmpresa, $startDate, $endDate)
    {
        // Determinar intervalo basado en la diferencia de días
        $diffDays = $endDate->diffInDays($startDate);
        
        if ($diffDays <= 31) {
            // Datos diarios para períodos cortos
            $clientsByPeriod = DB::table('Clients')
                ->select(DB::raw('DATE(CreatedAt) as period'), DB::raw('COUNT(*) as total'))
                ->where('idEmpresa', $idEmpresa)
                ->whereBetween('CreatedAt', [$startDate, $endDate])
                ->groupBy('period')
                ->orderBy('period')
                ->get();
                
            $labels = [];
            $data = [];
            
            // Crear array de fechas para incluir días sin nuevos clientes
            $currentDate = clone $startDate;
            while ($currentDate <= $endDate) {
                $dateStr = $currentDate->format('Y-m-d');
                $labels[] = $currentDate->format('d M');
                
                $found = false;
                foreach ($clientsByPeriod as $client) {
                    if ($client->period == $dateStr) {
                        $data[] = $client->total;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $data[] = 0;
                }
                
                $currentDate->addDay();
            }
        } else {
            // Datos mensuales para períodos largos
            $clientsByPeriod = DB::table('Clients')
                ->select(DB::raw('YEAR(CreatedAt) as year, MONTH(CreatedAt) as month'), DB::raw('COUNT(*) as total'))
                ->where('idEmpresa', $idEmpresa)
                ->whereBetween('CreatedAt', [$startDate, $endDate])
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
                
            $labels = [];
            $data = [];
            
            // Crear array de meses para incluir meses sin nuevos clientes
            $currentDate = clone $startDate->startOfMonth();
            $endMonthDate = clone $endDate->endOfMonth();
            
            while ($currentDate <= $endMonthDate) {
                $year = $currentDate->year;
                $month = $currentDate->month;
                $labels[] = $currentDate->format('M Y');
                
                $found = false;
                foreach ($clientsByPeriod as $client) {
                    if ($client->year == $year && $client->month == $month) {
                        $data[] = $client->total;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $data[] = 0;
                }
                
                $currentDate->addMonth();
            }
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    private function getSalesDistributionData($idEmpresa, $startDate, $endDate)
    {
        // Añadir registro para depuración
        \Illuminate\Support\Facades\Log::info("Obteniendo datos de ventas por producto", [
            'idEmpresa' => $idEmpresa,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s')
        ]);
        
        try {
            // Verificar si hay ventas para esta empresa y período
            $ventasCount = DB::table('SalesProposals')
                ->where('idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('SalesProposals.State', 'completed')
                          ->orWhere('SalesProposals.State', 'Completed')
                          ->orWhere('SalesProposals.State', 'confirmado')
                          ->orWhere('SalesProposals.State', 'Confirmado');
                })
                ->whereBetween('CreatedAt', [$startDate, $endDate])
                ->count();
                
            \Illuminate\Support\Facades\Log::info("Total de ventas encontradas: {$ventasCount}");
            
            // Obtener ventas por producto/servicio
            $salesByProduct = DB::table('SalesProposals')
                ->select('ProductsServices.Name', DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('SalesProposals.State', 'completed')
                          ->orWhere('SalesProposals.State', 'Completed')
                          ->orWhere('SalesProposals.State', 'confirmado')
                          ->orWhere('SalesProposals.State', 'Confirmado');
                })
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
                ->groupBy('ProductsServices.Name')
                ->orderBy('total', 'desc')
                ->limit(6) // Limitar a los 6 productos principales
                ->get();
                
            \Illuminate\Support\Facades\Log::info("Resultados de ventas por producto", [
                'count' => $salesByProduct->count(),
                'data' => $salesByProduct
            ]);
            
            // Si no hay datos, intentar obtener todas las ventas sin restricción de estado
            if ($salesByProduct->count() == 0 && $ventasCount == 0) {
                \Illuminate\Support\Facades\Log::warning("No se encontraron ventas confirmadas, buscando todas las ventas");
                
                // Verificar todos los estados de ventas disponibles
                $availableStates = DB::table('SalesProposals')
                    ->select('State')
                    ->where('idEmpresa', $idEmpresa)
                    ->whereBetween('CreatedAt', [$startDate, $endDate])
                    ->distinct()
                    ->get()
                    ->pluck('State')
                    ->toArray();
                    
                \Illuminate\Support\Facades\Log::info("Estados de ventas encontrados: ", $availableStates);
                
                // Obtener ventas por producto sin filtro de estado
                $allSalesByProduct = DB::table('SalesProposals')
                    ->select('ProductsServices.Name', 'SalesProposals.State', DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
                    ->where('SalesProposals.idEmpresa', $idEmpresa)
                    ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                    ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                    ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
                    ->groupBy('ProductsServices.Name', 'SalesProposals.State')
                    ->orderBy('total', 'desc')
                    ->get();
                    
                \Illuminate\Support\Facades\Log::info("Todas las ventas por producto y estado:", [
                    'count' => $allSalesByProduct->count(),
                    'data' => $allSalesByProduct
                ]);
                
                // Si hay resultados sin filtro, usarlos
                if ($allSalesByProduct->count() > 0) {
                    // Agrupar por producto, sumando los totales
                    $productTotals = [];
                    foreach ($allSalesByProduct as $sale) {
                        if (!isset($productTotals[$sale->Name])) {
                            $productTotals[$sale->Name] = 0;
                        }
                        $productTotals[$sale->Name] += $sale->total;
                    }
                    
                    // Convertir a array de objetos para mantener la misma estructura
                    $salesByProduct = collect();
                    foreach ($productTotals as $name => $total) {
                        $salesByProduct->push((object)[
                            'Name' => $name,
                            'total' => $total
                        ]);
                    }
                    
                    // Ordenar por total y limitar a 6
                    $salesByProduct = $salesByProduct->sortByDesc('total')->take(6)->values();
                    
                    \Illuminate\Support\Facades\Log::info("Ventas agrupadas por producto:", [
                        'count' => $salesByProduct->count(),
                        'data' => $salesByProduct
                    ]);
                }
            }
            
            // Si aún no hay datos, buscar productos existentes y usarlos con valores cero
            if ($salesByProduct->count() == 0) {
                \Illuminate\Support\Facades\Log::warning("No se encontraron datos de ventas por producto, creando datos de ejemplo");
                
                $products = DB::table('ProductsServices')
                    ->where('idEmpresa', $idEmpresa)
                    ->limit(3)
                    ->get(['Name']);
                    
                if ($products->count() > 0) {
                    $mockData = [];
                    foreach ($products as $product) {
                        $mockData[] = (object) [
                            'Name' => $product->Name,
                            'total' => 0
                        ];
                    }
                    $salesByProduct = collect($mockData);
                    
                    \Illuminate\Support\Facades\Log::info("Datos de ejemplo creados", [
                        'mockData' => $mockData
                    ]);
                } else {
                    // Si no hay productos, crear algunos ficticios
                    $salesByProduct = collect([
                        (object) ['Name' => 'Producto 1', 'total' => 0],
                        (object) ['Name' => 'Producto 2', 'total' => 0],
                        (object) ['Name' => 'Producto 3', 'total' => 0]
                    ]);
                    
                    \Illuminate\Support\Facades\Log::info("Datos ficticios creados");
                }
            }
                
            $labels = $salesByProduct->pluck('Name')->toArray();
            $data = $salesByProduct->pluck('total')->toArray();
            
            // Generar colores para el gráfico
            $backgroundColors = [
                '#3F95FF', // Azul
                '#10b981', // Verde
                '#8b5cf6', // Púrpura
                '#f59e0b', // Ámbar
                '#ef4444', // Rojo
                '#06b6d4', // Cyan
                '#ec4899'  // Rosa
            ];
            
            $result = [
                'labels' => $labels,
                'data' => $data,
                'colors' => array_slice($backgroundColors, 0, count($labels))
            ];
            
            \Illuminate\Support\Facades\Log::info("Datos de ventas por producto preparados", $result);
            
            return $result;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al obtener datos de ventas por producto: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            // En caso de error, devolver datos básicos para que al menos se muestre algo
            return [
                'labels' => ['Error al cargar datos'],
                'data' => [0],
                'colors' => ['#ef4444']
            ];
        }
    }
    
    private function getLeadsStatusData($idEmpresa, $startDate, $endDate)
    {
        // Obtener número de leads por estado
        $leadsByStatus = DB::table('Leads')
            ->select('Status', DB::raw('COUNT(*) as total'))
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('CreatedAt', [$startDate, $endDate])
            ->groupBy('Status')
            ->get();
            
        $labels = [];
        $data = [];
        $colors = [
            'New' => 'rgba(54, 162, 235, 0.8)',
            'In Progress' => 'rgba(255, 206, 86, 0.8)',
            'Qualified' => 'rgba(75, 192, 192, 0.8)',
            'Disqualified' => 'rgba(255, 99, 132, 0.8)',
            'Converted' => 'rgba(153, 102, 255, 0.8)'
        ];
        $backgroundColors = [];
        
        foreach ($leadsByStatus as $leadStatus) {
            $labels[] = $leadStatus->Status;
            $data[] = $leadStatus->total;
            $backgroundColors[] = $colors[$leadStatus->Status] ?? 'rgba(199, 199, 199, 0.8)';
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $backgroundColors
        ];
    }
    
    private function getTopProducts($idEmpresa, $startDate, $endDate)
    {
        // Añadir depuración
        \Illuminate\Support\Facades\Log::info("Obteniendo productos top", [
            'idEmpresa' => $idEmpresa,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s')
        ]);
        
        try {
            // Obtener productos/servicios con mejor rendimiento
            $topProducts = DB::table('SalesProposals')
                ->select(
                    'ProductsServices.idProductService',
                    'ProductsServices.Name',
                    DB::raw('SUM(SalesDetails.QuantitySold) as quantity'),
                    DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as revenue')
                )
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('SalesProposals.State', 'completed')
                          ->orWhere('SalesProposals.State', 'Completed')
                          ->orWhere('SalesProposals.State', 'confirmado')
                          ->orWhere('SalesProposals.State', 'Confirmado');
                })
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
                ->groupBy('ProductsServices.idProductService', 'ProductsServices.Name')
                ->orderBy('revenue', 'desc')
                ->limit(5)
                ->get();
                
            \Illuminate\Support\Facades\Log::info("Productos top encontrados:", [
                'count' => $topProducts->count(),
                'data' => $topProducts
            ]);
            
            // Si no hay resultados, intentar sin filtro de estado
            if ($topProducts->count() == 0) {
                \Illuminate\Support\Facades\Log::warning("No se encontraron productos top con ventas confirmadas, buscando todos los estados");
                
                // Verificar todos los estados disponibles
                $availableStates = DB::table('SalesProposals')
                    ->select('State')
                    ->where('idEmpresa', $idEmpresa)
                    ->whereBetween('CreatedAt', [$startDate, $endDate])
                    ->distinct()
                    ->get()
                    ->pluck('State')
                    ->toArray();
                    
                \Illuminate\Support\Facades\Log::info("Estados de ventas disponibles: ", $availableStates);
                
                // Obtener todos los productos con ventas en cualquier estado
                $topProductsAllStates = DB::table('SalesProposals')
                    ->select(
                        'ProductsServices.idProductService',
                        'ProductsServices.Name',
                        'SalesProposals.State',
                        DB::raw('SUM(SalesDetails.QuantitySold) as quantity'),
                        DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as revenue')
                    )
                    ->where('SalesProposals.idEmpresa', $idEmpresa)
                    ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                    ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                    ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
                    ->groupBy('ProductsServices.idProductService', 'ProductsServices.Name', 'SalesProposals.State')
                    ->orderBy('revenue', 'desc')
                    ->get();
                    
                \Illuminate\Support\Facades\Log::info("Todos los productos por estado:", [
                    'count' => $topProductsAllStates->count(),
                    'data' => $topProductsAllStates
                ]);
                
                // Si hay resultados sin filtro, agruparlos por producto
                if ($topProductsAllStates->count() > 0) {
                    $productTotals = [];
                    foreach ($topProductsAllStates as $product) {
                        if (!isset($productTotals[$product->idProductService])) {
                            $productTotals[$product->idProductService] = [
                                'idProductService' => $product->idProductService,
                                'Name' => $product->Name,
                                'quantity' => 0,
                                'revenue' => 0
                            ];
                        }
                        $productTotals[$product->idProductService]['quantity'] += $product->quantity;
                        $productTotals[$product->idProductService]['revenue'] += $product->revenue;
                    }
                    
                    // Convertir a collection
                    $topProducts = collect(array_values($productTotals));
                    
                    // Ordenar por revenue y limitar a 5
                    $topProducts = $topProducts->sortByDesc('revenue')->take(5)->values();
                    
                    foreach ($topProducts as $product) {
                        $product = (object)$product;
                    }
                    
                    \Illuminate\Support\Facades\Log::info("Productos agrupados:", [
                        'count' => $topProducts->count(),
                        'data' => $topProducts
                    ]);
                }
            }
            
            // Si aún no hay resultados, usar productos existentes con valores cero
            if ($topProducts->count() == 0) {
                \Illuminate\Support\Facades\Log::warning("No se encontraron productos con ventas, usando productos existentes");
                
                $products = DB::table('ProductsServices')
                    ->where('idEmpresa', $idEmpresa)
                    ->limit(5)
                    ->get(['idProductService', 'Name']);
                    
                if ($products->count() > 0) {
                    $mockData = [];
                    foreach ($products as $product) {
                        $mockData[] = (object) [
                            'idProductService' => $product->idProductService,
                            'Name' => $product->Name,
                            'quantity' => 0,
                            'revenue' => 0,
                            'growth' => 0
                        ];
                    }
                    $topProducts = collect($mockData);
                } else {
                    // Si no hay productos, crear datos de ejemplo
                    $topProducts = collect([
                        (object) ['idProductService' => 1, 'Name' => 'Producto 1', 'quantity' => 0, 'revenue' => 0, 'growth' => 0],
                        (object) ['idProductService' => 2, 'Name' => 'Producto 2', 'quantity' => 0, 'revenue' => 0, 'growth' => 0],
                        (object) ['idProductService' => 3, 'Name' => 'Producto 3', 'quantity' => 0, 'revenue' => 0, 'growth' => 0]
                    ]);
                }
            } else {
                // Calcular crecimiento comparando con período anterior
                $previousPeriodDays = $endDate->diffInDays($startDate);
                $previousPeriodStart = (clone $startDate)->subDays($previousPeriodDays);
                $previousPeriodEnd = (clone $startDate)->subDay();
                
                foreach ($topProducts as $product) {
                    $previousRevenue = DB::table('SalesProposals')
                        ->where('SalesProposals.idEmpresa', $idEmpresa)
                        ->where(function($query) {
                            $query->where('SalesProposals.State', 'completed')
                                ->orWhere('SalesProposals.State', 'Completed')
                                ->orWhere('SalesProposals.State', 'confirmado')
                                ->orWhere('SalesProposals.State', 'Confirmado');
                        })
                        ->whereBetween('SalesProposals.CreatedAt', [$previousPeriodStart, $previousPeriodEnd])
                        ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                        ->where('SalesDetails.ProductServiceID', $product->idProductService)
                        ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
                        
                    $product->growth = $previousRevenue > 0 
                        ? round((($product->revenue - $previousRevenue) / $previousRevenue) * 100, 1)
                        : ($product->revenue > 0 ? 100 : 0);
                }
            }
            
            return $topProducts;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al obtener productos top: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            // En caso de error, devolver array vacío
            return collect([]);
        }
    }
} 