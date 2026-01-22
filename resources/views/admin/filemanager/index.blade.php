<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .file-manager { height: 100vh; display: flex; flex-direction: column; }
        .toolbar { background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 1rem; }
        .content { flex: 1; display: flex; }
        .sidebar { width: 200px; background: #f8f9fa; border-right: 1px solid #dee2e6; padding: 1rem; }
        .main { flex: 1; padding: 1rem; }
        .file-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
        .file-item { border: 1px solid #dee2e6; border-radius: 8px; padding: 1rem; text-align: center; cursor: pointer; transition: all 0.2s; }
        .file-item:hover { border-color: #007bff; background: #f8f9ff; }
        .file-item.selected { border-color: #007bff; background: #e3f2fd; }
        .file-preview { width: 100px; height: 100px; margin: 0 auto 0.5rem; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 4px; }
        .file-preview img { max-width: 100%; max-height: 100%; object-fit: cover; border-radius: 4px; }
        .file-icon { font-size: 2rem; color: #6c757d; }
        .file-name { font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; word-break: break-all; }
        .file-size { font-size: 0.75rem; color: #6c757d; }
        .upload-area { border: 2px dashed #dee2e6; border-radius: 8px; padding: 2rem; text-align: center; margin-bottom: 1rem; transition: all 0.2s; }
        .upload-area.dragover { border-color: #007bff; background: #f8f9ff; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem; transition: all 0.2s; }
        .btn-primary { background: #007bff; color: white; }
        .btn-primary:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #545b62; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        .loading { display: none; text-align: center; padding: 2rem; }
        .actions { margin-top: 1rem; display: flex; gap: 0.5rem; justify-content: center; }
    </style>
</head>
<body>
    <div class="file-manager">
        <div class="toolbar">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0;">File Manager - {{ ucfirst($type) }}s</h3>
                <div>
                    <button class="btn btn-secondary" onclick="refreshFiles()">Refresh</button>
                    <button class="btn btn-primary" onclick="selectFile()" id="selectBtn" disabled>Select</button>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="sidebar">
                <h4>Upload New File</h4>
                <div class="upload-area" id="uploadArea">
                    <div>
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7,10 12,15 17,10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <p>Drop files here or click to upload</p>
                    </div>
                    <input type="file" id="fileInput" style="display: none;" {{ $type === 'image' ? 'accept="image/*"' : '' }} multiple>
                </div>
                
                <div class="actions">
                    <button class="btn btn-danger" onclick="deleteSelected()" id="deleteBtn" disabled>Delete</button>
                </div>
            </div>
            
            <div class="main">
                <div class="loading" id="loading">Loading files...</div>
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
            loadFiles();
            setupUpload();
        });

        // Load files from server
        function loadFiles() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('fileGrid').innerHTML = '';
            
            fetch(`/admin/filemanager/browse?type=${fileType}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loading').style.display = 'none';
                    if (data.success) {
                        files = data.files;
                        renderFiles();
                    }
                })
                .catch(error => {
                    document.getElementById('loading').style.display = 'none';
                    console.error('Error loading files:', error);
                });
        }

        // Render files in grid
        function renderFiles() {
            const grid = document.getElementById('fileGrid');
            grid.innerHTML = '';
            
            if (files.length === 0) {
                grid.innerHTML = '<p style="text-align: center; color: #6c757d; grid-column: 1 / -1;">No files found</p>';
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
        }

        // Select file and return to editor
        function selectFile() {
            if (!selectedFile) return;
            
            // For TinyMCE integration
            if (window.parent && window.parent.tinymce) {
                const activeEditor = window.parent.tinymce.activeEditor;
                if (activeEditor && activeEditor.windowManager) {
                    activeEditor.windowManager.close();
                    if (fileType === 'image') {
                        activeEditor.insertContent(`<img src="${selectedFile.url}" alt="${selectedFile.name}" style="max-width: 100%;">`);
                    } else {
                        activeEditor.insertContent(`<a href="${selectedFile.url}" target="_blank">${selectedFile.name}</a>`);
                    }
                }
            }
            
            // For direct callback
            if (window.parent && window.parent.setFileUrl) {
                window.parent.setFileUrl(selectedFile.url);
            }
        }

        // Delete selected file
        function deleteSelected() {
            if (!selectedFile) return;
            
            if (confirm('Are you sure you want to delete this file?')) {
                fetch('/admin/filemanager/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ path: selectedFile.path })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadFiles();
                        selectedFile = null;
                        document.getElementById('selectBtn').disabled = true;
                        document.getElementById('deleteBtn').disabled = true;
                    }
                });
            }
        }

        // Refresh files
        function refreshFiles() {
            loadFiles();
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
            Array.from(fileList).forEach(file => {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('type', fileType);
                
                fetch('/admin/filemanager/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadFiles();
                    } else {
                        alert('Upload failed: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Upload failed');
                });
            });
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