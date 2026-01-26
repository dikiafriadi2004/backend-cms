<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Manager</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            margin: 0; 
            padding: 0; 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background: #f8f9fa;
        }
        .file-manager { 
            height: 100vh; 
            display: flex; 
            flex-direction: column; 
            max-height: 100vh;
            overflow: hidden;
        }
        .toolbar { 
            background: #fff; 
            border-bottom: 1px solid #dee2e6; 
            padding: 1rem; 
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .content { 
            flex: 1; 
            display: flex; 
            min-height: 0;
        }
        .sidebar { 
            width: 250px; 
            background: #fff; 
            border-right: 1px solid #dee2e6; 
            padding: 1rem; 
            flex-shrink: 0;
            overflow-y: auto;
        }
        .main { 
            flex: 1; 
            padding: 1rem; 
            overflow-y: auto;
            background: #f8f9fa;
        }
        .file-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); 
            gap: 1rem; 
        }
        .file-item { 
            background: #fff;
            border: 2px solid #e9ecef; 
            border-radius: 8px; 
            padding: 0.75rem; 
            text-align: center; 
            cursor: pointer; 
            transition: all 0.2s;
            position: relative;
        }
        .file-item:hover { 
            border-color: #007bff; 
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }
        .file-item.selected { 
            border-color: #007bff; 
            background: #e3f2fd; 
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
        .file-preview { 
            width: 80px; 
            height: 80px; 
            margin: 0 auto 0.5rem; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: #f8f9fa; 
            border-radius: 4px; 
            overflow: hidden;
        }
        .file-preview img { 
            max-width: 100%; 
            max-height: 100%; 
            object-fit: cover; 
            border-radius: 4px; 
        }
        .file-icon { 
            font-size: 2rem; 
            color: #6c757d; 
        }
        .file-name { 
            font-size: 0.75rem; 
            font-weight: 500; 
            margin-bottom: 0.25rem; 
            word-break: break-all; 
            line-height: 1.2;
            max-height: 2.4em;
            overflow: hidden;
        }
        .file-size { 
            font-size: 0.65rem; 
            color: #6c757d; 
        }
        .upload-area { 
            border: 2px dashed #dee2e6; 
            border-radius: 8px; 
            padding: 1.5rem; 
            text-align: center; 
            margin-bottom: 1rem; 
            transition: all 0.2s;
            background: #fff;
        }
        .upload-area.dragover { 
            border-color: #007bff; 
            background: #f8f9ff; 
        }
        .btn { 
            padding: 0.5rem 1rem; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 0.875rem; 
            transition: all 0.2s;
            font-weight: 500;
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .btn-primary { 
            background: #007bff; 
            color: white; 
        }
        .btn-primary:hover:not(:disabled) { 
            background: #0056b3; 
        }
        .btn-secondary { 
            background: #6c757d; 
            color: white; 
        }
        .btn-secondary:hover { 
            background: #545b62; 
        }
        .btn-danger { 
            background: #dc3545; 
            color: white; 
        }
        .btn-danger:hover:not(:disabled) { 
            background: #c82333; 
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
        }
        .loading { 
            display: none; 
            text-align: center; 
            padding: 2rem; 
            color: #6c757d;
        }
        .actions { 
            margin-top: 1rem; 
            display: flex; 
            gap: 0.5rem; 
            flex-direction: column;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }
        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        .connection-status {
            padding: 0.5rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        .connection-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .connection-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .toolbar-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
        }
        .toolbar-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="file-manager">
        <div class="toolbar">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="toolbar-title">File Manager - {{ ucfirst($type) }}s</h3>
                <div class="toolbar-actions">
                    <button class="btn btn-secondary" onclick="refreshFiles()">
                        <span>🔄</span> Refresh
                    </button>
                    <button class="btn btn-success" onclick="selectFile()" id="selectBtn" disabled>
                        <span>✓</span> Select
                    </button>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="sidebar">
                <div id="connectionStatus"></div>
                
                <h4 style="margin-top: 0; margin-bottom: 1rem; font-size: 1rem; color: #495057;">Upload New File</h4>
                <div class="upload-area" id="uploadArea">
                    <div>
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 0.5rem;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7,10 12,15 17,10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <p style="margin: 0; font-size: 0.875rem;">Drop files here or click to upload</p>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.75rem; color: #6c757d;">
                            {{ $type === 'image' ? 'Images only' : 'All file types' }}
                        </p>
                    </div>
                    <input type="file" id="fileInput" style="display: none;" {{ $type === 'image' ? 'accept="image/*"' : '' }} multiple>
                </div>
                
                <div class="actions">
                    <button class="btn btn-danger" onclick="deleteSelected()" id="deleteBtn" disabled>
                        <span>🗑️</span> Delete
                    </button>
                    <button class="btn btn-secondary" onclick="testConnection()" style="font-size: 0.75rem;">
                        Test Connection
                    </button>
                </div>
            </div>
            
            <div class="main">
                <div class="loading" id="loading">
                    <div>Loading files...</div>
                </div>
                <div class="file-grid" id="fileGrid"></div>
            </div>
        </div>
    </div>

    <script>
        const fileType = '{{ $type }}';
        const editorField = '{{ $editor }}';
        let selectedFile = null;
        let files = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('File Manager initialized');
            console.log('File type:', fileType);
            console.log('Editor field:', editorField);
            
            checkConnection();
            loadFiles();
            setupUpload();
        });

        // Check connection to parent window
        function checkConnection() {
            const statusDiv = document.getElementById('connectionStatus');
            let status = '';
            let isConnected = false;

            if (window.parent && window.parent !== window) {
                if (window.parent.tinymce && window.parent.tinymce.activeEditor) {
                    status = '✅ Connected to TinyMCE editor';
                    isConnected = true;
                } else if (window.parent.setFileUrl) {
                    status = '✅ Connected to parent window';
                    isConnected = true;
                } else {
                    status = '⚠️ Parent window found but no editor detected';
                }
            } else {
                status = '❌ No parent window detected';
            }

            statusDiv.innerHTML = `<div class="connection-${isConnected ? 'success' : 'error'}">${status}</div>`;
        }

        // Load files from server
        function loadFiles() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('fileGrid').innerHTML = '';
            
            const url = new URL('/admin/filemanager/browse', window.location.origin);
            url.searchParams.set('type', fileType);
            
            fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Browse response status:', response.status);
                
                if (response.status === 401 || response.status === 419) {
                    throw new Error('Authentication required. Please refresh the parent page and try again.');
                }
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                console.log('Files loaded:', data);
                
                if (data.success) {
                    files = data.files || [];
                    renderFiles();
                } else {
                    throw new Error(data.message || 'Failed to load files');
                }
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                console.error('Error loading files:', error);
                
                const errorMsg = error.message.includes('Authentication') 
                    ? 'Authentication error. Please refresh the parent page and try again.'
                    : `Connection error: ${error.message}`;
                    
                document.getElementById('fileGrid').innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <p style="color: #dc3545; font-weight: 500;">Error loading files</p>
                        <p style="font-size: 0.875rem;">${errorMsg}</p>
                        <button class="btn btn-primary" onclick="loadFiles()" style="margin-top: 1rem;">Try Again</button>
                    </div>
                `;
            });
        }

        // Render files in grid
        function renderFiles() {
            const grid = document.getElementById('fileGrid');
            grid.innerHTML = '';
            
            if (files.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13,2 13,9 20,9"></polyline>
                        </svg>
                        <p>No files found</p>
                        <p style="font-size: 0.875rem; color: #6c757d;">Upload some files to get started</p>
                    </div>
                `;
                return;
            }
            
            files.forEach(file => {
                const item = document.createElement('div');
                item.className = 'file-item';
                item.onclick = () => selectFileItem(file, item);
                
                const preview = document.createElement('div');
                preview.className = 'file-preview';
                
                if (file.type && file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = file.url;
                    img.alt = file.name;
                    img.onerror = function() {
                        this.style.display = 'none';
                        const icon = document.createElement('div');
                        icon.className = 'file-icon';
                        icon.innerHTML = '🖼️';
                        preview.appendChild(icon);
                    };
                    preview.appendChild(img);
                } else {
                    const icon = document.createElement('div');
                    icon.className = 'file-icon';
                    icon.innerHTML = '📄';
                    preview.appendChild(icon);
                }
                
                const name = document.createElement('div');
                name.className = 'file-name';
                name.textContent = file.name;
                name.title = file.name;
                
                const size = document.createElement('div');
                size.className = 'file-size';
                size.textContent = formatFileSize(file.size);
                
                item.appendChild(preview);
                item.appendChild(name);
                item.appendChild(size);
                grid.appendChild(item);
            });
        }

        // Select file item
        function selectFileItem(file, element) {
            // Remove previous selection
            document.querySelectorAll('.file-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Select current item
            element.classList.add('selected');
            selectedFile = file;
            
            // Enable buttons
            document.getElementById('selectBtn').disabled = false;
            document.getElementById('deleteBtn').disabled = false;
            
            console.log('File selected:', file);
        }

        // Select file and return to editor
        function selectFile() {
            if (!selectedFile) {
                alert('Please select a file first');
                return;
            }
            
            console.log('=== FILE SELECTION DEBUG ===');
            console.log('Selected file object:', selectedFile);
            console.log('Selected file URL:', selectedFile.url);
            console.log('Selected file name:', selectedFile.name);
            console.log('Selected file path:', selectedFile.path);
            
            // Method 1: Use parent window callback (most reliable)
            if (window.parent && typeof window.parent.setFileUrl === 'function') {
                console.log('Using parent.setFileUrl method');
                try {
                    window.parent.setFileUrl(selectedFile.url);
                    return;
                } catch (e) {
                    console.error('Error calling parent.setFileUrl:', e);
                }
            }
            
            // Method 2: Post message to parent window
            if (window.parent && window.parent !== window) {
                console.log('Using postMessage method');
                try {
                    window.parent.postMessage({
                        mceAction: 'fileSelected',
                        url: selectedFile.url,
                        alt: selectedFile.name
                    }, '*');
                    
                    // Try to close the window
                    setTimeout(() => {
                        if (window.parent.tinymce && window.parent.tinymce.activeEditor) {
                            window.parent.tinymce.activeEditor.windowManager.close();
                        }
                    }, 100);
                    return;
                } catch (e) {
                    console.error('Error posting message:', e);
                }
            }
            
            // Method 3: Try direct TinyMCE access
            let editor = null;
            
            try {
                // Try parent window first
                if (window.parent && window.parent.tinymce && window.parent.tinymce.activeEditor) {
                    editor = window.parent.tinymce.activeEditor;
                    console.log('Found editor in parent window');
                }
                // Try top window
                else if (window.top && window.top.tinymce && window.top.tinymce.activeEditor) {
                    editor = window.top.tinymce.activeEditor;
                    console.log('Found editor in top window');
                }
                
                if (editor) {
                    console.log('Inserting content directly into editor');
                    
                    // Close the dialog first
                    if (editor.windowManager) {
                        editor.windowManager.close();
                    }
                    
                    // Insert content based on file type
                    setTimeout(() => {
                        if (fileType === 'image') {
                            editor.insertContent(`<img src="${selectedFile.url}" alt="${selectedFile.name}" style="max-width: 100%;">`);
                        } else {
                            editor.insertContent(`<a href="${selectedFile.url}" target="_blank">${selectedFile.name}</a>`);
                        }
                        editor.focus();
                    }, 200);
                    return;
                }
            } catch (e) {
                console.error('Error accessing TinyMCE:', e);
            }
            
            // If all methods fail, show success message and URL
            alert(`File selected successfully!\n\nURL: ${selectedFile.url}\n\nIf the file wasn't inserted automatically, you can copy this URL manually.`);
        }

        // Delete selected file
        function deleteSelected() {
            if (!selectedFile) {
                alert('Please select a file first');
                return;
            }
            
            if (!confirm(`Are you sure you want to delete "${selectedFile.name}"?`)) {
                return;
            }
            
            fetch('/admin/filemanager/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ path: selectedFile.path })
            })
            .then(response => {
                if (response.status === 401 || response.status === 419) {
                    throw new Error('Authentication required. Please refresh the parent page and try again.');
                }
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    loadFiles();
                    selectedFile = null;
                    document.getElementById('selectBtn').disabled = true;
                    document.getElementById('deleteBtn').disabled = true;
                } else {
                    throw new Error(data.message || 'Failed to delete file');
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                alert('Delete failed: ' + error.message);
            });
        }

        // Refresh files
        function refreshFiles() {
            loadFiles();
            checkConnection();
        }
        
        // Test connection to parent window
        function testConnection() {
            let messages = [];
            
            messages.push('=== File Manager Connection Test ===');
            messages.push(`File type: ${fileType}`);
            messages.push(`Editor field: ${editorField}`);
            messages.push(`Current URL: ${window.location.href}`);
            messages.push('');
            messages.push('Window Information:');
            messages.push(`- Window parent available: ${!!window.parent}`);
            messages.push(`- Parent !== window: ${window.parent !== window}`);
            messages.push(`- Window top available: ${!!window.top}`);
            messages.push('');
            messages.push('TinyMCE Information:');
            messages.push(`- Parent TinyMCE available: ${!!(window.parent && window.parent.tinymce)}`);
            messages.push(`- Parent setFileUrl available: ${!!(window.parent && window.parent.setFileUrl)}`);
            
            if (window.parent && window.parent.tinymce) {
                messages.push(`- Active editor available: ${!!window.parent.tinymce.activeEditor}`);
                if (window.parent.tinymce.activeEditor) {
                    messages.push(`- Window manager available: ${!!window.parent.tinymce.activeEditor.windowManager}`);
                }
            }
            
            messages.push(`- Top TinyMCE available: ${!!(window.top && window.top.tinymce)}`);
            
            alert(messages.join('\n'));
        }

        // Setup file upload
        function setupUpload() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            
            uploadArea.onclick = () => fileInput.click();
            
            // Drag and drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                handleFiles(e.dataTransfer.files);
            });
            
            fileInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
            });
        }

        // Handle file upload
        function handleFiles(fileList) {
            if (fileList.length === 0) return;
            
            Array.from(fileList).forEach(file => {
                // Validate file type if needed
                if (fileType === 'image' && !file.type.startsWith('image/')) {
                    alert(`File "${file.name}" is not an image and will be skipped.`);
                    return;
                }
                
                const formData = new FormData();
                formData.append('file', file);
                formData.append('type', fileType);
                
                fetch('/admin/filemanager/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: formData
                })
                .then(response => {
                    if (response.status === 401 || response.status === 419) {
                        throw new Error('Authentication required. Please refresh the parent page and try again.');
                    }
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('File uploaded successfully:', data);
                        loadFiles();
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert(`Upload failed for "${file.name}": ${error.message}`);
                });
            });
            
            // Clear the input
            fileInput.value = '';
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html>