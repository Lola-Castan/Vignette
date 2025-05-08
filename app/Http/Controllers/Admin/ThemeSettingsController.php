<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeSettingsController extends Controller
{
    /**
     * Affiche le formulaire de configuration du thème
     */
    public function index()
    {
        // Récupérer la valeur actuelle de l'opacité depuis le fichier de configuration
        $opacity = file_exists(storage_path('app/theme_settings.json')) 
            ? json_decode(file_get_contents(storage_path('app/theme_settings.json')), true)['opacity'] ?? 1.0
            : 1.0;
            
        // Récupérer la liste des images disponibles dans le dossier backgrounds
        $backgroundImages = Storage::disk('public')->files('backgrounds');
        // Formater les noms des fichiers pour l'affichage
        $backgroundImages = array_map(function($path) {
            return basename($path);
        }, $backgroundImages);
        
        // Récupérer l'image actuellement sélectionnée
        $currentImage = file_exists(storage_path('app/theme_settings.json')) 
            ? json_decode(file_get_contents(storage_path('app/theme_settings.json')), true)['background_image'] ?? 'backgroundchat.jpg'
            : 'backgroundchat.jpg';
            
        return view('admin.theme_settings', compact('opacity', 'backgroundImages', 'currentImage'));
    }
    
    /**
     * Enregistre les modifications des paramètres du thème
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'opacity' => 'required|numeric|min:0|max:1',
            'background_image' => 'required|string',
            'new_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Gérer le téléchargement d'une nouvelle image si fournie
        if ($request->hasFile('new_background')) {
            $file = $request->file('new_background');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('backgrounds', $file, $filename);
            $validated['background_image'] = $filename;
        }
        
        // Enregistrer les paramètres dans un fichier de configuration
        $settings = [
            'opacity' => (float) $validated['opacity'],
            'background_image' => $validated['background_image']
        ];
        
        file_put_contents(storage_path('app/theme_settings.json'), json_encode($settings));
        
        // Mettre à jour le fichier JavaScript pour refléter les changements
        $this->updateThemeScript($settings);
        
        return redirect()->route('admin.theme.settings')->with('success', 'Les paramètres du thème ont été mis à jour avec succès.');
    }
    
    /**
     * Met à jour le script JavaScript du thème avec les nouveaux paramètres
     */
    private function updateThemeScript($settings)
    {
        $opacity = $settings['opacity'];
        $imagePath = $settings['background_image'];
        
        // Lire le fichier theme-switcher.js
        $themeFile = file_get_contents(resource_path('js/theme-switcher.js'));
        
        // Rechercher et remplacer la propriété d'image de fond uniquement dans le thème image
        $pattern = "/(image\s*:\s*\{[^}]*)'--main-bg-image'\s*:\s*'url\(\"[^\"]+\"\)'/s";
        $replacement = "$1'--main-bg-image': 'url(\"/storage/backgrounds/" . $imagePath . "\")'";
        $themeFile = preg_replace($pattern, $replacement, $themeFile);
        
        // Mettre à jour la propriété d'opacité uniquement dans le thème image
        $pattern = "/(image\s*:\s*\{[^}]*)'--main-bg-opacity'\s*:\s*'[^']*'/s";
        $replacement = "$1'--main-bg-opacity': '" . $opacity . "'";
        $themeFile = preg_replace($pattern, $replacement, $themeFile);
        
        // Enregistrer le fichier modifié
        file_put_contents(resource_path('js/theme-switcher.js'), $themeFile);
    }
}
