<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clients;
use App\Models\Note;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $idEmpresa = session('empresa_id');
        
        if (!$idEmpresa) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }
        
        // Obtener estadísticas generales
        $stats = $this->getGeneralStats($idEmpresa);
        
        // Obtener datos para gráfico de ventas
        $salesData = $this->getSalesData($idEmpresa);
        
        // Obtener actividades recientes
        $recentActivities = $this->getRecentActivities($idEmpresa);
        
        return view('dashboard', compact('stats', 'salesData', 'recentActivities'));
    }
    
    private function getGeneralStats($idEmpresa)
    {
        // Total de clientes
        $totalClients = DB::table('Clients')->where('idEmpresa', $idEmpresa)->count();
        
        // Calcular porcentaje de crecimiento de clientes (últimos 30 días)
        $lastMonthClients = DB::table('Clients')
            ->where('idEmpresa', $idEmpresa)
            ->where('CreatedAt', '<=', Carbon::now()->subDays(30))
            ->count();
        
        $clientGrowth = $lastMonthClients > 0 
            ? round((($totalClients - $lastMonthClients) / $lastMonthClients) * 100, 1)
            : 100;
            
        // Proyectos activos
        $activeProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->where('Status', 'In Progress')
            ->count();
            
        // Calcular porcentaje de crecimiento de proyectos (últimos 30 días)
        $lastMonthProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->where('Status', 'In Progress')
            ->where('CreatedAt', '<=', Carbon::now()->subDays(30))
            ->count();
            
        $projectGrowth = $lastMonthProjects > 0 
            ? round((($activeProjects - $lastMonthProjects) / $lastMonthProjects) * 100, 1)
            : 100;
            
        // Facturación mensual - ventas confirmadas
        $currentMonthSales = DB::table('SalesProposals')
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where(function($query) {
                $query->where('SalesProposals.State', 'Efectuada')
                      ->orWhere('SalesProposals.State', 'efectuada')
                      ->orWhere('SalesProposals.State', 'completed')
                      ->orWhere('SalesProposals.State', 'Completed')
                      ->orWhere('SalesProposals.State', 'confirmado')
                      ->orWhere('SalesProposals.State', 'Confirmado')
                      ->orWhereIn('SalesProposals.State', ['confirmed', 'Confirmed', 'finalizado', 'Finalizado']);
            })
            ->where('SalesProposals.CreatedAt', '>=', Carbon::now()->startOfMonth())
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
            
        // Facturación por proyectos completados en el mes actual
        $currentMonthCompletedProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->where(function($query) {
                $query->where('Status', 'Completed')
                      ->orWhere('Status', 'completed')
                      ->orWhere('Status', 'Completado')
                      ->orWhere('Status', 'completado')
                      ->orWhere('Status', 'Finalizado')
                      ->orWhere('Status', 'finalizado');
            })
            ->where('UpdatedAt', '>=', Carbon::now()->startOfMonth())
            ->sum('Budget');
            
        // Sumar las ventas y los proyectos completados
        $totalCurrentMonthBilling = $currentMonthSales + $currentMonthCompletedProjects;
            
        // Ventas del mes anterior
        $lastMonthSales = DB::table('SalesProposals')
            ->where('SalesProposals.idEmpresa', $idEmpresa)
            ->where(function($query) {
                $query->where('SalesProposals.State', 'Efectuada')
                      ->orWhere('SalesProposals.State', 'efectuada')
                      ->orWhere('SalesProposals.State', 'completed')
                      ->orWhere('SalesProposals.State', 'Completed')
                      ->orWhere('SalesProposals.State', 'confirmado')
                      ->orWhere('SalesProposals.State', 'Confirmado')
                      ->orWhereIn('SalesProposals.State', ['confirmed', 'Confirmed', 'finalizado', 'Finalizado']);
            })
            ->whereBetween('SalesProposals.CreatedAt', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
            ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
            
        // Proyectos completados del mes anterior
        $lastMonthCompletedProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->where(function($query) {
                $query->where('Status', 'Completed')
                      ->orWhere('Status', 'completed')
                      ->orWhere('Status', 'Completado')
                      ->orWhere('Status', 'completado')
                      ->orWhere('Status', 'Finalizado')
                      ->orWhere('Status', 'finalizado');
            })
            ->whereBetween('UpdatedAt', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->sum('Budget');
            
        // Total facturación mes anterior
        $totalLastMonthBilling = $lastMonthSales + $lastMonthCompletedProjects;
            
        // Calcular porcentaje de crecimiento
        $salesGrowth = $totalLastMonthBilling > 0 
            ? round((($totalCurrentMonthBilling - $totalLastMonthBilling) / $totalLastMonthBilling) * 100, 1)
            : 100;
            
        // Notas activas (usadas como tickets de soporte en este ejemplo)
        $activeNotes = DB::table('Notes')
            ->where('idEmpresa', $idEmpresa)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();
            
        // Cambio en número de notas respecto al mes anterior
        $previousPeriodNotes = DB::table('Notes')
            ->where('idEmpresa', $idEmpresa)
            ->whereBetween('created_at', [
                Carbon::now()->subDays(60),
                Carbon::now()->subDays(30)
            ])
            ->count();
            
        $notesChange = $activeNotes - $previousPeriodNotes;
        
        return [
            'clients' => [
                'total' => $totalClients,
                'growth' => $clientGrowth
            ],
            'projects' => [
                'total' => $activeProjects,
                'growth' => $projectGrowth
            ],
            'sales' => [
                'total' => $totalCurrentMonthBilling,
                'growth' => $salesGrowth
            ],
            'notes' => [
                'total' => $activeNotes,
                'change' => $notesChange
            ]
        ];
    }
    
    private function getSalesData($idEmpresa)
    {
        // Obtener ventas de los últimos 12 meses
        $salesByMonth = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M');
            $year = $date->format('Y');
            
            // Ventas confirmadas para el mes
            $monthlySales = DB::table('SalesProposals')
                ->where('SalesProposals.idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('SalesProposals.State', 'Efectuada')
                          ->orWhere('SalesProposals.State', 'efectuada')
                          ->orWhere('SalesProposals.State', 'completed')
                          ->orWhere('SalesProposals.State', 'Completed')
                          ->orWhere('SalesProposals.State', 'confirmado')
                          ->orWhere('SalesProposals.State', 'Confirmado')
                          ->orWhereIn('SalesProposals.State', ['confirmed', 'Confirmed', 'finalizado', 'Finalizado']);
                })
                ->whereYear('SalesProposals.CreatedAt', $date->year)
                ->whereMonth('SalesProposals.CreatedAt', $date->month)
                ->join('SalesDetails', 'SalesProposals.idSalesProposals', '=', 'SalesDetails.ProposalID')
                ->sum(DB::raw('SalesDetails.QuantitySold * SalesDetails.UnitPrice'));
                
            // Proyectos completados para el mes
            $monthlyProjectsRevenue = DB::table('Projects')
                ->where('idEmpresa', $idEmpresa)
                ->where(function($query) {
                    $query->where('Status', 'Completed')
                          ->orWhere('Status', 'completed')
                          ->orWhere('Status', 'Completado')
                          ->orWhere('Status', 'completado')
                          ->orWhere('Status', 'Finalizado')
                          ->orWhere('Status', 'finalizado');
                })
                ->whereYear('UpdatedAt', $date->year)
                ->whereMonth('UpdatedAt', $date->month)
                ->sum('Budget');
                
            // Sumar ambos tipos de ingresos
            $totalMonthlyRevenue = $monthlySales + $monthlyProjectsRevenue;
                
            $salesByMonth[] = [
                'month' => $month,
                'year' => $year,
                'amount' => $totalMonthlyRevenue
            ];
        }
        
        return $salesByMonth;
    }
    
    private function getRecentActivities($idEmpresa)
    {
        $activities = [];
        
        // Nuevos clientes
        $recentClients = DB::table('Clients')
            ->where('idEmpresa', $idEmpresa)
            ->orderBy('CreatedAt', 'desc')
            ->take(3)
            ->get(['idClient', 'Name', 'LastName', 'CreatedAt']);
            
        foreach ($recentClients as $client) {
            $activities[] = [
                'type' => 'client',
                'title' => 'Nuevo cliente registrado',
                'detail' => $client->Name . ' ' . $client->LastName,
                'time' => Carbon::parse($client->CreatedAt)->diffForHumans(),
                'timestamp' => $client->CreatedAt
            ];
        }
        
        // Proyectos completados
        $completedProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->where('Status', 'Completed')
            ->orderBy('UpdatedAt', 'desc')
            ->take(3)
            ->get(['idProject', 'Name', 'UpdatedAt']);
            
        foreach ($completedProjects as $project) {
            $activities[] = [
                'type' => 'project_completed',
                'title' => 'Proyecto completado',
                'detail' => $project->Name,
                'time' => Carbon::parse($project->UpdatedAt)->diffForHumans(),
                'timestamp' => $project->UpdatedAt
            ];
        }
        
        // Nuevos proyectos
        $newProjects = DB::table('Projects')
            ->where('idEmpresa', $idEmpresa)
            ->orderBy('CreatedAt', 'desc')
            ->take(3)
            ->get(['idProject', 'Name', 'CreatedAt']);
            
        foreach ($newProjects as $project) {
            $activities[] = [
                'type' => 'project_created',
                'title' => 'Nuevo proyecto creado',
                'detail' => $project->Name,
                'time' => Carbon::parse($project->CreatedAt)->diffForHumans(),
                'timestamp' => $project->CreatedAt
            ];
        }
        
        // Nuevas notas (como tickets de soporte)
        $recentNotes = DB::table('Notes')
            ->where('idEmpresa', $idEmpresa)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get(['idNote', 'Title', 'created_at']);
            
        foreach ($recentNotes as $note) {
            $activities[] = [
                'type' => 'note',
                'title' => 'Nueva anotación',
                'detail' => $note->Title,
                'time' => Carbon::parse($note->created_at)->diffForHumans(),
                'timestamp' => $note->created_at
            ];
        }
        
        // Ordenar actividades por timestamp (más recientes primero)
        usort($activities, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        // Devolver las 5 actividades más recientes
        return array_slice($activities, 0, 5);
    }
} 