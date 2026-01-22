import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Advanced TinyMCE Configuration (Self-hosted, no API key required)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.tinymce-editor',
            height: 500,
            menubar: 'file edit view insert format tools table help',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
                'template', 'codesample', 'hr', 'pagebreak', 'nonbreaking',
                'textpattern'
            ],
            toolbar1: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist',
            toolbar2: 'forecolor backcolor | removeformat | charmap emoticons | fullscreen preview | insertfile image media template link anchor codesample | ltr rtl',
            toolbar3: 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            
            // Content styling
            content_style: `
                body { 
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                    font-size: 14px; 
                    line-height: 1.6; 
                    color: #333;
                    max-width: 100%;
                    margin: 0 auto;
                    padding: 20px;
                }
                img { max-width: 100%; height: auto; }
                table { border-collapse: collapse; width: 100%; }
                table td, table th { border: 1px solid #ddd; padding: 8px; }
                table th { background-color: #f2f2f2; }
                blockquote { 
                    border-left: 4px solid #ccc; 
                    margin: 1.5em 10px; 
                    padding: 0.5em 10px; 
                    background: #f9f9f9;
                }
                code { 
                    background-color: #f4f4f4; 
                    padding: 2px 4px; 
                    border-radius: 3px; 
                    font-family: monospace;
                }
                pre { 
                    background-color: #f4f4f4; 
                    padding: 10px; 
                    border-radius: 5px; 
                    overflow-x: auto;
                }
            `,
            
            // Advanced options
            branding: false,
            promotion: false,
            resize: true,
            elementpath: true,
            statusbar: true,
            
            // Disable quickbars to prevent popup toolbars
            quickbars_selection_toolbar: false,
            quickbars_insert_toolbar: false,
            
            // Image handling
            automatic_uploads: true,
            images_upload_url: '/admin/filemanager/upload',
            images_upload_base_path: '/storage',
            images_upload_credentials: true,
            images_upload_handler: function (blobInfo, success, failure, progress) {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/admin/filemanager/upload');
                
                xhr.upload.onprogress = function (e) {
                    progress(e.loaded / e.total * 100);
                };
                
                xhr.onload = function() {
                    if (xhr.status === 403) {
                        failure('HTTP Error: ' + xhr.status, { remove: true });
                        return;
                    }
                    
                    if (xhr.status < 200 || xhr.status >= 300) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    
                    const json = JSON.parse(xhr.responseText);
                    
                    if (!json || typeof json.url != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    
                    success(json.url);
                };
                
                xhr.onerror = function () {
                    failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };
                
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('type', 'image');
                
                // Add CSRF token
                const token = document.querySelector('meta[name="csrf-token"]');
                if (token) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', token.getAttribute('content'));
                }
                
                xhr.send(formData);
            },
            
            // File picker for images and files
            file_picker_callback: function(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                let cmsURL = '/admin/filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=image";
                } else {
                    cmsURL = cmsURL + "&type=file";
                }

                tinymce.activeEditor.windowManager.openUrl({
                    url : cmsURL,
                    title : 'File Manager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
                
                // Global callback for file selection
                window.setFileUrl = function(url) {
                    callback(url);
                    tinymce.activeEditor.windowManager.close();
                };
            },
            
            // Templates
            templates: [
                {
                    title: 'Two Columns',
                    description: 'Two column layout',
                    content: '<div style="display: flex; gap: 20px;"><div style="flex: 1;"><h3>Column 1</h3><p>Content for column 1</p></div><div style="flex: 1;"><h3>Column 2</h3><p>Content for column 2</p></div></div>'
                },
                {
                    title: 'Call to Action',
                    description: 'Call to action box',
                    content: '<div style="background: #f8f9fa; border: 2px solid #007bff; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0;"><h3 style="color: #007bff; margin-top: 0;">Call to Action</h3><p>Your compelling message here</p><a href="#" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Learn More</a></div>'
                },
                {
                    title: 'Quote Box',
                    description: 'Highlighted quote',
                    content: '<blockquote style="font-size: 1.2em; font-style: italic; border-left: 4px solid #007bff; padding-left: 20px; margin: 20px 0; background: #f8f9fa; padding: 15px 20px;"><p>"Your inspiring quote goes here"</p><footer style="font-size: 0.9em; margin-top: 10px;">— Author Name</footer></blockquote>'
                }
            ],
            
            // Text patterns for quick formatting (disabled to prevent conflicts)
            textpattern_patterns: [],
            
            // Context menu
            contextmenu: 'link image table',
            
            // Setup callback
            setup: function(editor) {
                editor.on('init', function() {
                    console.log('TinyMCE initialized successfully');
                });
                
                // Disable inline toolbars completely
                editor.on('selectionchange', function() {
                    // Prevent any inline toolbar from showing
                });
            }
        });
    }
});

// Sortable functionality for menu items
if (typeof Sortable !== 'undefined') {
    document.addEventListener('DOMContentLoaded', function() {
        const sortableList = document.getElementById('menu-items');
        if (sortableList) {
            new Sortable(sortableList, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    // Update order via AJAX
                    const items = Array.from(sortableList.children).map((item, index) => ({
                        id: item.dataset.id,
                        order: index + 1
                    }));
                    
                    fetch('/admin/menus/update-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ items })
                    });
                }
            });
        }
    });
}
