<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotesController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$this->permissionService->hasPermission('notas', 'ver')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para ver notas');
        }
        
        // Get user company ID from session
        $idEmpresa = session('empresa_id');
        $related = $request->query('related');
        $relatedId = $request->query('related_id');
        
        // Build query
        $query = Note::where('idEmpresa', $idEmpresa);
        
        // Filter by related entity if provided
        if ($related && $relatedId) {
            $query->where('RelatedTo', $related)
                  ->where('RelatedID', $relatedId);
        }
        
        // Get notes with pagination
        $notes = $query->orderBy('created_at', 'desc')
                      ->with('creator')
                      ->paginate(10);
        
        // Return view with notes
        return view('notes.index', compact('notes', 'related', 'relatedId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$this->permissionService->hasPermission('notas', 'crear')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para crear notas');
        }
        
        // Get related entity info from query parameters
        $related = $request->query('related', 'general');
        $relatedId = $request->query('related_id');
        
        return view('notes.create', compact('related', 'relatedId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->permissionService->hasPermission('notas', 'crear')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes permiso para crear notas'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permiso para crear notas');
        }

        // Validate request
        $validated = $request->validate([
            'Title' => 'required|string|max:100',
            'Content' => 'nullable|string',
            'RelatedTo' => 'required|in:client,lead,project,sale,general',
            'RelatedID' => 'nullable|integer'
        ]);
        
        try {
            // Get user ID and company ID from session
            $userId = session('user_id');
            $idEmpresa = session('empresa_id');
            $userType = session('user_type');
            
            Log::info('Información de sesión al crear nota:', [
                'userId' => $userId,
                'empresaId' => $idEmpresa,
                'userType' => $userType
            ]);
            
            if (!$userId || !$idEmpresa) {
                Log::error('User or company ID not found in session');
                return redirect()->route('notes.create')->with('error', 'Error de sesión. Por favor, vuelve a iniciar sesión.');
            }

            // Obtener un ID de usuario válido para CreatedBy
            $createdBy = null;
            
            // Si es un usuario normal, verificar que existe en la base de datos
            if ($userType !== 'admin') {
                $user = DB::table('Users')->where('idUser', $userId)->first();
                if ($user) {
                    $createdBy = $userId;
                    Log::info("Usuario normal: usando su propio ID como CreatedBy: $createdBy");
                }
            }
            
            // Si es admin o no se encontró el usuario, buscar un usuario válido en la empresa
            if ($createdBy === null) {
                $anyUser = DB::table('Users')
                    ->where('idEmpresa', $idEmpresa)
                    ->first();
                
                if ($anyUser) {
                    $createdBy = $anyUser->idUser;
                    Log::info("Encontrado usuario de la empresa para CreatedBy: $createdBy");
                } else {
                    // Si no hay usuarios en esta empresa, buscar cualquier usuario en el sistema
                    $fallbackUser = DB::table('Users')->first();
                    
                    if ($fallbackUser) {
                        $createdBy = $fallbackUser->idUser;
                        Log::info("Usando usuario de respaldo como CreatedBy: $createdBy");
                    } else {
                        // No hay usuarios en el sistema - caso extremadamente raro
                        Log::error("No se encontraron usuarios en el sistema para asignar como CreatedBy");
                        return redirect()->route('notes.create')
                            ->with('error', 'Error al crear nota: No hay usuarios disponibles en el sistema.');
                    }
                }
            }
            
            // Ahora que tenemos un CreatedBy válido, crear la nota
            $note = new Note([
                'Title' => $validated['Title'],
                'Content' => $validated['Content'],
                'RelatedTo' => $validated['RelatedTo'],
                'RelatedID' => $validated['RelatedTo'] === 'general' ? null : $validated['RelatedID'],
                'CreatedBy' => $createdBy,
                'idEmpresa' => $idEmpresa
            ]);
            
            $note->save();
            Log::info("Nota creada con ID: " . $note->idNote);
            
            // Handle AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Nota creada correctamente',
                    'note' => $note
                ]);
            }
            
            // Siempre redirigir a la lista de notas, independientemente de la relación
            return redirect()->route('notes.index')->with('success', 'Nota creada correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al crear nota: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('notes.create')->with('error', 'Error al crear nota: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->permissionService->hasPermission('notas', 'ver')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para ver notas');
        }
        
        $note = Note::with('creator')->find($id);
        
        if (!$note) {
            return redirect()->route('notes.index')->with('error', 'Nota no encontrada');
        }
        
        // Check if note belongs to user's company
        if ($note->idEmpresa != session('empresa_id')) {
            return redirect()->route('notes.index')->with('error', 'No tienes acceso a esta nota');
        }
        
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$this->permissionService->hasPermission('notas', 'editar')) {
            return redirect('/dashboard')->with('error', 'No tienes permiso para editar notas');
        }
        
        $note = Note::find($id);
        
        if (!$note) {
            return redirect()->route('notes.index')->with('error', 'Nota no encontrada');
        }
        
        // Check if note belongs to user's company
        if ($note->idEmpresa != session('empresa_id')) {
            return redirect()->route('notes.index')->with('error', 'No tienes acceso a esta nota');
        }
        
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->permissionService->hasPermission('notas', 'editar')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes permiso para editar notas'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permiso para editar notas');
        }
        
        // Validate request
        $validated = $request->validate([
            'Title' => 'required|string|max:100',
            'Content' => 'nullable|string',
            'RelatedTo' => 'required|in:client,lead,project,sale,general',
            'RelatedID' => 'nullable|integer'
        ]);
        
        $note = Note::find($id);
        
        if (!$note) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Nota no encontrada'], 404);
            }
            return redirect()->route('notes.index')->with('error', 'Nota no encontrada');
        }
        
        // Check if note belongs to user's company
        if ($note->idEmpresa != session('empresa_id')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes acceso a esta nota'], 403);
            }
            return redirect()->route('notes.index')->with('error', 'No tienes acceso a esta nota');
        }
        
        // Update the note
        $note->update([
            'Title' => $validated['Title'],
            'Content' => $validated['Content'],
            'RelatedTo' => $validated['RelatedTo'],
            'RelatedID' => $validated['RelatedTo'] === 'general' ? null : $validated['RelatedID']
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Nota actualizada correctamente']);
        }
        
        return redirect()->route('notes.show', $id)->with('success', 'Nota actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (!$this->permissionService->hasPermission('notas', 'borrar')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes permiso para eliminar notas'], 403);
            }
            return redirect('/dashboard')->with('error', 'No tienes permiso para eliminar notas');
        }
        
        $note = Note::find($id);
        
        if (!$note) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Nota no encontrada'], 404);
            }
            return redirect()->route('notes.index')->with('error', 'Nota no encontrada');
        }
        
        // Check if note belongs to user's company
        if ($note->idEmpresa != session('empresa_id')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No tienes acceso a esta nota'], 403);
            }
            return redirect()->route('notes.index')->with('error', 'No tienes acceso a esta nota');
        }
        
        // Get related entity info for redirection after delete
        $related = $note->RelatedTo;
        $relatedId = $note->RelatedID;
        
        // Delete the note
        $note->delete();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Nota eliminada correctamente']);
        }
        
        // Redirect based on related entity or referer
        if ($request->headers->has('referer')) {
            return redirect($request->headers->get('referer'))->with('success', 'Nota eliminada correctamente');
        }
        
        return redirect()->route('notes.index')->with('success', 'Nota eliminada correctamente');
    }
} 