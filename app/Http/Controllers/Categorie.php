<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Affiche la liste des catégories.
     */
    public function index()
    {
        $categories = Categorie::all();
        return view('dashboard.menu.indexcat', compact('categories'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie.
     */
    public function create()
    {
        return view('categories.create');
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
        return redirect()->route('categories.index')
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
        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprime une catégorie de la base de données.
     */
    public function destroy($id)
    {
        $category = Categorie::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Catégorie supprimée avec succès !');
    }
}
