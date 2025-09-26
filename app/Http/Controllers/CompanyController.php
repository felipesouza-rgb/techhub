<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('companies.index', ['companies' => Company::latest()->paginate(10)]);
    }
    public function create()
    {
        return view('companies.create');
    }
    public function store(Request $r)
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        Company::create($data);
        return redirect()->route('companies.index')->with('success', 'Company created');
    }
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }
    public function update(Request $r, Company $company)
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        $company->update($data);
        return redirect()->route('companies.index')->with('success', 'Company updated');
    }
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted');
    }

    public function show(\App\Models\Company $company)
{
    // Paginação separada para não “quebrar” o objeto $company
    $projects = $company->projects()
        ->withCount(['backlogs', 'changelogs']) // se tiver essas relações no Project
        ->latest()
        ->paginate(10);

    return view('companies.show', compact('company', 'projects'));
}
}
