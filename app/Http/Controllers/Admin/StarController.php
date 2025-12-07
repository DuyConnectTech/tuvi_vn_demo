<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Star\StoreStarRequest;
use App\Http\Requests\Admin\Star\UpdateStarRequest;
use App\Models\Star;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $stars = Star::latest()->paginate(20);
        return view('admin.stars.index', compact('stars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.stars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStarRequest $request): RedirectResponse
    {
        Star::create($request->validated());

        return redirect()->route('admin.stars.index')
            ->with('success', 'Sao mới đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Star $star)
    {
        // View detail if needed, currently redirect to edit
        return redirect()->route('admin.stars.edit', $star);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Star $star): View
    {
        return view('admin.stars.edit', compact('star'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStarRequest $request, Star $star): RedirectResponse
    {
        $star->update($request->validated());

        return redirect()->route('admin.stars.index')
            ->with('success', 'Thông tin sao đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Star $star): RedirectResponse
    {
        $star->delete();

        return redirect()->route('admin.stars.index')
            ->with('success', 'Sao đã được xóa thành công.');
    }
}