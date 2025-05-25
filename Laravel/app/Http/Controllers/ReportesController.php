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
        
        // Total de ventas (completadas)
        $totalSales = DB::table('SalesProposals')
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where('SalesProposals.State', 'completed')
            ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
            
        // Ventas del período anterior para comparación
        $previousPeriodSales = DB::table('SalesProposals')
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where('SalesProposals.State', 'completed')
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
        // Determinar intervalo basado en la diferencia de días
        $diffDays = $endDate->diffInDays($startDate);
        
        if ($diffDays <= 31) {
            // Datos diarios para períodos cortos
            $salesByPeriod = DB::table('SalesProposals')
                ->select(DB::raw('DATE(CreatedAt) as period'), DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where('SalesProposals.State', 'completed')
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->groupBy('period')
                ->orderBy('period')
                ->get();
                
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
                ->where('SalesProposals.State', 'completed')
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
                
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
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
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
        // Obtener ventas por categoría de producto/servicio
        $salesByCategory = DB::table('SalesProposals')
            ->select('ProductsServices.Name', DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where('SalesProposals.State', 'completed')
            ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
            ->groupBy('ProductsServices.Name')
            ->orderBy('total', 'desc')
            ->limit(6) // Limitar a las 6 categorías principales
            ->get();
            
        $labels = $salesByCategory->pluck('Name')->toArray();
        $data = $salesByCategory->pluck('total')->toArray();
        
        // Si hay más de 6 categorías, agrupar el resto como "Otros"
        $totalCategoriesCount = DB::table('SalesProposals')
            ->select(DB::raw('COUNT(DISTINCT ProductsServices.Name) as total_categories'))
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where('SalesProposals.State', 'completed')
            ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
            ->value('total_categories');
            
        if ($totalCategoriesCount > 6) {
            $otherCategoriesTotal = DB::table('SalesProposals')
                ->select(DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as total'))
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where('SalesProposals.State', 'completed')
                ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
                ->whereNotIn('ProductsServices.Name', $labels)
                ->value('total');
                
            if ($otherCategoriesTotal && $otherCategoriesTotal > 0) {
                $labels[] = 'Otros';
                $data[] = $otherCategoriesTotal;
            }
        }
        
        // Generar colores para el gráfico
        $backgroundColors = [
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 99, 132, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(199, 199, 199, 0.8)'
        ];
        
        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => array_slice($backgroundColors, 0, count($labels))
        ];
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
        // Obtener productos/servicios con mejor rendimiento
        $topProducts = DB::table('SalesProposals')
            ->select(
                'ProductsServices.idProductService',
                'ProductsServices.Name',
                DB::raw('SUM(SalesDetails.QuantitySold) as quantity'),
                DB::raw('SUM(SalesDetails.QuantitySold * SalesDetails.UnitPrice) as revenue')
            )
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where('SalesProposals.State', 'completed')
            ->whereBetween('SalesProposals.CreatedAt', [$startDate, $endDate])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->join('ProductsServices', 'SalesDetails.ProductServiceID', '=', 'ProductsServices.idProductService')
            ->groupBy('ProductsServices.idProductService', 'ProductsServices.Name')
            ->orderBy('revenue', 'desc')
            ->limit(5)
            ->get();
            
        // Calcular crecimiento comparando con período anterior
        $previousPeriodDays = $endDate->diffInDays($startDate);
        $previousPeriodStart = (clone $startDate)->subDays($previousPeriodDays);
        $previousPeriodEnd = (clone $startDate)->subDay();
        
        foreach ($topProducts as $product) {
            $previousRevenue = DB::table('SalesProposals')
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where('SalesProposals.State', 'completed')
                ->whereBetween('SalesProposals.CreatedAt', [$previousPeriodStart, $previousPeriodEnd])
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->where('SalesDetails.ProductServiceID', $product->idProductService)
                ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
                
            $product->growth = $previousRevenue > 0 
                ? round((($product->revenue - $previousRevenue) / $previousRevenue) * 100, 1)
                : ($product->revenue > 0 ? 100 : 0);
        }
        
        return $topProducts;
    }
} 