<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        
        // Get filter parameters
        $status = $request->input('status', '');
        $search = $request->input('search', '');
        $clientId = $request->input('client', '');
        
        // Build query
        $projects = Project::where('idEmpresa', $idEmpresa)
            ->when($status, function ($query, $status) {
                return $query->where('Status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where('Name', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%');
            })
            ->when($clientId, function ($query, $clientId) {
                return $query->where('ClientID', $clientId);
            })
            ->orderBy('CreatedAt', 'desc')
            ->paginate(10);
        
        // Get clients for the filter dropdown
        $clients = Client::where('idEmpresa', $idEmpresa)->get();
        
        // Get project statistics
        $stats = [
            'total' => Project::where('idEmpresa', $idEmpresa)->count(),
            'pending' => Project::where('idEmpresa', $idEmpresa)->where('Status', 'Pending')->count(),
            'in_progress' => Project::where('idEmpresa', $idEmpresa)->where('Status', 'In Progress')->count(),
            'completed' => Project::where('idEmpresa', $idEmpresa)->where('Status', 'Completed')->count(),
        ];
        
        return view('proyectos.index', compact('projects', 'clients', 'stats'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        $clients = Client::where('idEmpresa', $idEmpresa)->get();
        
        return view('proyectos.create', compact('clients'));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:100',
            'Description' => 'nullable|string',
            'ClientID' => 'nullable|exists:Clients,idClient',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'Status' => 'required|in:Pending,In Progress,Completed,Cancelled',
            'Budget' => 'nullable|numeric|min:0',
            'BillingType' => 'required|in:Fixed,Hourly,None',
            'Notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('proyectos.create')
                ->withErrors($validator)
                ->withInput();
        }

        $project = new Project();
        $project->Name = $request->input('Name');
        $project->Description = $request->input('Description');
        $project->ClientID = $request->input('ClientID');
        $project->StartDate = $request->input('StartDate');
        $project->EndDate = $request->input('EndDate');
        $project->Status = $request->input('Status');
        $project->Budget = $request->input('Budget');
        $project->BillingType = $request->input('BillingType');
        $project->Notes = $request->input('Notes');
        $project->idEmpresa = $idEmpresa;
        $project->save();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        $project = Project::where('idEmpresa', $idEmpresa)
            ->where('idProject', $id)
            ->firstOrFail();
        
        // Load related notes
        $notes = $project->notes()->orderBy('created_at', 'desc')->get();
        
        // Load client information
        $client = $project->client;
        
        return view('proyectos.show', compact('project', 'notes', 'client'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        $project = Project::where('idEmpresa', $idEmpresa)
            ->where('idProject', $id)
            ->firstOrFail();
        
        $clients = Client::where('idEmpresa', $idEmpresa)->get();
        
        return view('proyectos.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        $project = Project::where('idEmpresa', $idEmpresa)
            ->where('idProject', $id)
            ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:100',
            'Description' => 'nullable|string',
            'ClientID' => 'nullable|exists:Clients,idClient',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'Status' => 'required|in:Pending,In Progress,Completed,Cancelled',
            'Budget' => 'nullable|numeric|min:0',
            'BillingType' => 'required|in:Fixed,Hourly,None',
            'Notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('proyectos.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $project->Name = $request->input('Name');
        $project->Description = $request->input('Description');
        $project->ClientID = $request->input('ClientID');
        $project->StartDate = $request->input('StartDate');
        $project->EndDate = $request->input('EndDate');
        $project->Status = $request->input('Status');
        $project->Budget = $request->input('Budget');
        $project->BillingType = $request->input('BillingType');
        $project->Notes = $request->input('Notes');
        $project->save();

        return redirect()->route('proyectos.show', $id)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $idEmpresa = $request->session()->get('empresa_id');
        $project = Project::where('idEmpresa', $idEmpresa)
            ->where('idProject', $id)
            ->firstOrFail();
        
        // Delete associated notes
        $project->notes()->delete();
        
        // Delete the project
        $project->delete();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
    }
} 