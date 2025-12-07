<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Glossary\StoreGlossaryRequest;
use App\Http\Requests\Admin\Glossary\UpdateGlossaryRequest;
use App\Models\Glossary;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GlossaryController extends Controller
{
    public function index(): View
    {
        $glossaries = Glossary::latest()->paginate(20);
        return view('admin.glossaries.index', compact('glossaries'));
    }

    public function create(): View
    {
        return view('admin.glossaries.create');
    }

    public function store(StoreGlossaryRequest $request): RedirectResponse
    {
        Glossary::create($request->validated());
        return redirect()->route('admin.glossaries.index')->with('success', 'Đã thêm thuật ngữ mới.');
    }

    public function edit(Glossary $glossary): View
    {
        return view('admin.glossaries.edit', compact('glossary'));
    }

    public function update(UpdateGlossaryRequest $request, Glossary $glossary): RedirectResponse
    {
        $glossary->update($request->validated());
        return redirect()->route('admin.glossaries.index')->with('success', 'Cập nhật thuật ngữ thành công.');
    }

    public function destroy(Glossary $glossary): RedirectResponse
    {
        $glossary->delete();
        return redirect()->route('admin.glossaries.index')->with('success', 'Đã xóa thuật ngữ.');
    }
}
