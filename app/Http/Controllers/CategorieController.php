<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Affiche la liste des catégories.
     */
    public function index(Request $request)
    {
        // Récupérer toutes les catégories
        $categories = Categorie::all();
    
        // Initialiser par défaut
        $categoryToEdit = null;
        $isEdit = false;
    
        // Vérifier si un paramètre ?edit est présent dans l'URL
        if ($request->has('edit')) {
            $categoryToEdit = Categorie::find($request->get('edit'));
            if ($categoryToEdit) {
                $isEdit = true;
            }
        }
    
        return view('dashboard.Admin.menu.indexcat', compact('categories', 'categoryToEdit', 'isEdit'));
    }
    

    /**
     * Enregistre une nouvelle catégorie dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        // Création
        Categorie::create([
            'label' => $request->label,
        ]);

        // Redirection après la création
        return redirect()->back()
                         ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Affiche les détails d'une catégorie spécifique.
     */
    public function show($id)
    {
        $category = Categorie::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Affiche le formulaire d'édition d'une catégorie existante.
     */
    public function edit($id)
    {
        $category = Categorie::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Met à jour une catégorie dans la base de données.
     */
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        // Mise à jour
        $category = Categorie::findOrFail($id);
        $category->update([
            'label' => $request->label,
        ]);

        // Redirection après la mise à jour
        return redirect()->back()
                         ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprime une catégorie de la base de données.
     */
    public function destroy($id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();

        return redirect()->back()
                         ->with('success', 'Catégorie supprimée avec succès !');
    }
}
