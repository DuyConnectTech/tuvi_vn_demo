<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\StoreTagRequest;
use App\Http\Requests\Admin\Tag\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::latest()->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        Tag::create($data);
        return redirect()->route('admin.tags.index')->with('success', 'Đã thêm tag mới.');
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $tag->update($data);
        return redirect()->route('admin.tags.index')->with('success', 'Cập nhật tag thành công.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Đã xóa tag.');
    }
}
