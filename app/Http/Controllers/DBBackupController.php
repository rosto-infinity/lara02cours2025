<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DBBackupController extends Controller
{
    private function formatSize($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' Go';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' Mo';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' Ko';
    } else {
        return $bytes . ' octets';
    }
}



   public function index()
{
    $backups = collect(Storage::files('private/backup'))
        ->filter(fn ($file) => Str::endsWith($file, '.gz'))
        ->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => $this->formatSize(Storage::size($file)), // Formatage ici
                'last_modified' => Storage::lastModified($file),
                'path' => $file,
                'raw_size' => Storage::size($file) // Conserve la taille brute si besoin
            ];
        })
        ->sortByDesc('last_modified')
        ->values();

    return view('pages.settings.DbBackup', [
        'backups' => $backups,
        'total' => Product::count(),
        'backupsCount' => collect(Storage::files('private/backup'))->count(),
    ]);
}



    /**
     * Télécharge une sauvegarde spécifique
     */
    public function download(Request $request): StreamedResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        if (!Storage::exists($request->path)) {
            abort(404);
        }

        return Storage::download($request->path);
    }

    /**
     * Crée une nouvelle sauvegarde
     */
    public function create()
    {
        Artisan::call('app:dbbackup');
        
        return redirect()->back()
            ->with('success', 'La sauvegarde a été lancée avec succès');
    }

    // Ajouter ces nouvelles méthodes à la classe DBBackupController

/**
 * Importe une sauvegarde
 */
public function import(Request $request)
{
    $request->validate([
        'backup_file' => 'required|file|mimetypes:application/gzip,application/x-gzip',
    ]);

    $file = $request->file('backup_file');
    $filename = 'imported_' . now()->format('Y-m-d_H-i-s') . '.gz';
    
    // Stocker le fichier importé
    $path = $file->storeAs('private/backup', $filename);

    return redirect()->back()
        ->with('success', 'La sauvegarde a été importée avec succès');
}

/**
 * Supprime une sauvegarde
 */
public function delete(Request $request)
{
    $request->validate([
        'path' => 'required|string',
    ]);

    if (!Storage::exists($request->path)) {
        abort(404);
    }

    Storage::delete($request->path);

    return redirect()->back()
        ->with('success', 'La sauvegarde a été supprimée avec succès');
}

/**
 * Restaure une sauvegarde
 */
public function restore(Request $request)
{
    $request->validate([
        'path' => 'required|string',
    ]);

    if (!Storage::exists($request->path)) {
        abort(404, 'Fichier de sauvegarde introuvable.');
    }

    // Appel de la commande Artisan pour restaurer la base de données
    Artisan::call('app:restoredb', ['file' => storage_path('app/' . $request->path)]);

    return redirect()->back()
        ->with('success', 'La sauvegarde a été restaurée avec succès.');
}


}
