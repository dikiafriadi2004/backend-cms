@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('subtitle', 'Manage menu items with drag & drop ordering')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Menu Information -->
    <div class="space-y-6">
        <form method="POST" action="{{ route('admin.menus.update', $menu) }}">
            @csrf
            @method('PUT')
            
            <div class="card animate-fade-in">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Menu Information
                    </h3>
                </div>
                <div class="card-body space-y-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Menu Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $menu->name) }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location" class="form-label">Location *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $menu->location) }}" 
                               class="form-input" required>
                        <p class="text-sm text-gray-500 mt-2">Unique identifier for this menu</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="3" 
                                  class="form-textarea">{{ old('description', $menu->description) }}</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Menu
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        <!-- Add Menu Item -->
        <div class="card animate-slide-up">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Menu Item
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.menus.add-item', $menu) }}" id="addItemForm">
                    @csrf
                    <div class="space-y-6">
                        <div class="form-group">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="type" class="form-label">Type *</label>
                            <select id="type" name="type" class="form-select" required>
                                <option value="custom">Custom Link</option>
                                <option value="page">Page</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="url-field">
                            <label for="url" class="form-label">URL *</label>
                            <input type="text" id="url" name="url" class="form-input" placeholder="https://example.com">
                        </div>
                        
                        <div class="form-group" id="page-field" style="display: none;">
                            <label for="page_id" class="form-label">Page *</label>
                            <select id="page_id" name="page_id" class="form-select">
                                <option value="">Select Page</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="target" class="form-label">Target</label>
                                <select id="target" name="target" class="form-select">
                                    <option value="_self">Same Window</option>
                                    <option value="_blank">New Window</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="css_class" class="form-label">CSS Class</label>
                                <input type="text" id="css_class" name="css_class" class="form-input" placeholder="Optional CSS class">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Menu Items with Drag & Drop -->
    <div>
        <div class="card animate-fade-in">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Menu Items
                    </h3>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                        <span>Drag to reorder</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($menu->parentItems->count() > 0)
                    <div id="menu-items" class="space-y-3">
                        @foreach($menu->parentItems->sortBy('order') as $item)
                            <div class="menu-item bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200" data-id="{{ $item->id }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="drag-handle flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 flex items-center">
                                                @if($item->type === 'page')
                                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                    </svg>
                                                @endif
                                                {{ $item->title }}
                                            </h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                @if($item->type === 'page' && $item->page)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">Page</span>
                                                    {{ $item->page->title }}
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-2">Link</span>
                                                    {{ $item->url }}
                                                @endif
                                                @if($item->target === '_blank')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 ml-2">New Window</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.menu-items.destroy', $item) }}" 
                                          class="inline" data-confirm-delete 
                                          data-confirm-title="Delete Menu Item"
                                          data-confirm-message="Are you sure you want to delete '{{ $item->title }}'? This action cannot be undone and will also remove any child items.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                
                                @if($item->children->count() > 0)
                                    <div class="mt-4 ml-8 space-y-2" id="submenu-{{ $item->id }}">
                                        @foreach($item->children->sortBy('order') as $child)
                                            <div class="menu-item bg-white p-3 rounded-lg border border-gray-100 shadow-sm" data-id="{{ $child->id }}">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="drag-handle flex-shrink-0">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <h5 class="text-sm font-semibold text-gray-800 flex items-center">
                                                                @if($child->type === 'page')
                                                                    <svg class="w-3 h-3 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-3 h-3 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                                    </svg>
                                                                @endif
                                                                {{ $child->title }}
                                                            </h5>
                                                            <p class="text-xs text-gray-500 mt-1">
                                                                @if($child->type === 'page' && $child->page)
                                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1">Page</span>
                                                                    {{ $child->page->title }}
                                                                @else
                                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-1">Link</span>
                                                                    {{ $child->url }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <form method="POST" action="{{ route('admin.menu-items.destroy', $child) }}" 
                                                          class="inline" data-confirm-delete 
                                                          data-confirm-title="Delete Menu Item"
                                                          data-confirm-message="Are you sure you want to delete '{{ $child->title }}'? This action cannot be undone.">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors duration-200">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No menu items yet</h3>
                        <p class="mt-2 text-gray-500">Add some items to get started building your menu.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form field toggling
    const typeSelect = document.getElementById('type');
    const urlField = document.getElementById('url-field');
    const pageField = document.getElementById('page-field');
    const urlInput = document.getElementById('url');
    const pageInput = document.getElementById('page_id');
    
    typeSelect.addEventListener('change', function() {
        if (this.value === 'page') {
            urlField.style.display = 'none';
            pageField.style.display = 'block';
            urlInput.removeAttribute('required');
            pageInput.setAttribute('required', 'required');
        } else {
            urlField.style.display = 'block';
            pageField.style.display = 'none';
            urlInput.setAttribute('required', 'required');
            pageInput.removeAttribute('required');
        }
    });
    
    // Initialize drag and drop for menu items
    const menuItemsContainer = document.getElementById('menu-items');
    if (menuItemsContainer) {
        new Sortable(menuItemsContainer, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateMenuOrder();
            }
        });
        
        // Initialize drag and drop for submenus
        document.querySelectorAll('[id^="submenu-"]').forEach(function(submenu) {
            new Sortable(submenu, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    updateMenuOrder();
                }
            });
        });
    }
    
    function updateMenuOrder() {
        const items = [];
        let order = 1;
        
        // Get main menu items
        document.querySelectorAll('#menu-items > .menu-item').forEach(function(item) {
            items.push({
                id: parseInt(item.dataset.id),
                order: order++
            });
            
            // Get submenu items
            const submenu = item.querySelector('[id^="submenu-"]');
            if (submenu) {
                let subOrder = 1;
                submenu.querySelectorAll('.menu-item').forEach(function(subItem) {
                    items.push({
                        id: parseInt(subItem.dataset.id),
                        order: subOrder++
                    });
                });
            }
        });
        
        // Send AJAX request to update order
        fetch('{{ route("admin.menus.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                order: items
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success feedback
                showNotification('Menu order updated successfully!', 'success');
            }
        })
        .catch(error => {
            console.error('Error updating menu order:', error);
            showNotification('Error updating menu order', 'error');
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
</script>
@endpush