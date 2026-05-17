@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage product categories')

@section('content')

<div class="grid xl:grid-cols-3 gap-6">

    {{-- Category list --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl border border-zinc-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Category</th>
                        <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Parent</th>
                        <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Products</th>
                        <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Status</th>
                        <th class="text-right px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @forelse($categories as $category)
                        <tr class="hover:bg-zinc-50 transition-colors" id="cat-{{ $category->id }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-surface-100 flex-shrink-0 overflow-hidden border border-zinc-100">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-zinc-900">{{ $category->name }}</p>
                                        <p class="text-xs text-zinc-400 font-mono">{{ $category->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-zinc-600 text-xs">
                                {{ $category->parent?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-sm font-medium text-zinc-700">{{ $category->products_count }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-zinc-100 text-zinc-500' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="editCategory({{ $category->id }}, {{ json_encode($category) }})"
                                            class="p-2 text-zinc-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                          onsubmit="return confirm('Delete {{ addslashes($category->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center text-zinc-400">No categories yet. Create your first one!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-5 py-4 border-t border-zinc-50">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    {{-- Create / Edit form --}}
    <div>
        <div class="bg-white rounded-2xl border border-zinc-100 p-6 sticky top-24">
            <h3 class="font-display font-semibold text-zinc-900 mb-5" id="formTitle">Add New Category</h3>

            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" id="categoryForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="category_id" id="categoryId">

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded-xl">
                        <ul class="text-xs text-red-700 space-y-1">
                            @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="catName" value="{{ old('name') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm"
                               placeholder="Electronics">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Parent Category</label>
                        <select name="parent_id" id="catParent"
                                class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 outline-none text-sm">
                            <option value="">No parent (top-level)</option>
                            @foreach($parentCategories as $pCat)
                                <option value="{{ $pCat->id }}" {{ old('parent_id') == $pCat->id ? 'selected' : '' }}>{{ $pCat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Description</label>
                        <textarea name="description" id="catDesc" rows="2"
                                  class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 outline-none text-sm resize-none"
                                  placeholder="Brief description...">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" id="catSort" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 outline-none text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Image</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                               class="w-full text-xs text-zinc-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-sm font-medium text-zinc-700">Active</span>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="catActive" value="1" checked
                               class="w-4 h-4 rounded border-zinc-300 text-brand-600 focus:ring-brand-500">
                    </label>
                </div>

                <div class="mt-5 flex gap-3">
                    <button type="submit"
                            class="flex-1 bg-brand-600 text-white font-semibold text-sm py-3 rounded-xl hover:bg-brand-700 transition-all">
                        <span id="submitLabel">Create Category</span>
                    </button>
                    <button type="button" onclick="resetForm()"
                            class="px-4 py-3 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-100 transition-colors">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editCategory(id, data) {
    document.getElementById('formTitle').textContent = 'Edit Category';
    document.getElementById('submitLabel').textContent = 'Save Changes';

    // Update form action to PUT /admin/categories/{id}
    const form = document.getElementById('categoryForm');
    form.action = `/admin/categories/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('categoryId').value = id;

    // Populate fields
    document.getElementById('catName').value  = data.name || '';
    document.getElementById('catDesc').value  = data.description || '';
    document.getElementById('catSort').value  = data.sort_order || 0;
    document.getElementById('catParent').value = data.parent_id || '';
    document.getElementById('catActive').checked = !!data.is_active;

    form.scrollIntoView({ behavior: 'smooth' });
}

function resetForm() {
    document.getElementById('formTitle').textContent  = 'Add New Category';
    document.getElementById('submitLabel').textContent = 'Create Category';
    document.getElementById('categoryForm').action    = '{{ route('admin.categories.store') }}';
    document.getElementById('formMethod').value       = 'POST';
    document.getElementById('categoryId').value       = '';
    document.getElementById('catName').value          = '';
    document.getElementById('catDesc').value          = '';
    document.getElementById('catSort').value          = 0;
    document.getElementById('catParent').value        = '';
    document.getElementById('catActive').checked      = true;
}
</script>
@endpush
