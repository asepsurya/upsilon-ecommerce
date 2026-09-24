window.AdminImageGallery = {
    init(config) {
        const uploadZone = document.querySelector(config.uploadZoneSelector);
        const fileInput = document.querySelector(config.fileInputSelector);
        const previewContainer = document.querySelector(config.previewContainerSelector);
        const hasProduct = config.hasProduct || false;

        if (!uploadZone || !fileInput || !previewContainer) return;

        let previewImages = [];

        function handleFiles(files) {
            const arr = Array.from(files).filter(f => f.type.startsWith('image/'));

            if (hasProduct) {
                arr.forEach(file => uploadViaAjax(file));
                return;
            }

            // Accumulate files into the file input so they get submitted with the form
            const dt = new DataTransfer(fileInput.files);
            arr.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;

            // Re-render previews from all accumulated files
            previewImages = [];
            Array.from(fileInput.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImages.push({
                        index: Date.now() + Math.random(),
                        data: e.target.result,
                        file: file,
                    });
                    renderLocalPreviews();
                };
                reader.readAsDataURL(file);
            });
        }

        function renderLocalPreviews() {
            let html = '';
            previewImages.forEach((img) => {
                html += '<div class="image-preview" data-preview-index="' + img.index + '">';
                html += '<img src="' + img.data + '" alt="Preview">';
                html += '<button type="button" class="remove-btn" title="Remove" data-preview-index="' + img.index + '">';
                html += '<span class="material-symbols-outlined" style="font-size: 14px;">close</span>';
                html += '</button>';
                html += '</div>';
            });

            previewContainer.innerHTML = html;

            previewContainer.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idx = parseFloat(this.dataset.previewIndex);
                    previewImages = previewImages.filter(img => img.index !== idx);

                    if (!hasProduct) {
                        const dt = new DataTransfer();
                        previewImages.forEach(img => dt.items.add(img.file));
                        fileInput.files = dt.files;
                    }

                    renderLocalPreviews();
                });
            });
        }

        function uploadViaAjax(file) {
            const formData = new FormData();
            formData.append('images[]', file);

            fetch(config.uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
                .then(r => {
                    const contentType = r.headers.get('content-type') || '';
                    if (!contentType.includes('application/json')) {
                        throw new Error('Server returned non-JSON response');
                    }
                    return r.json();
                })
                .then(data => {
                    if (data.success) {
                        loadServerImages();
                    } else {
                        console.error('Upload failed:', data.message);
                    }
                })
                .catch(err => console.error('Upload error:', err));
        }

        function loadServerImages() {
            if (!config.indexUrl) return;

            fetch(config.indexUrl)
                .then(r => {
                    const contentType = r.headers.get('content-type') || '';
                    if (!contentType.includes('application/json')) {
                        throw new Error('Server returned non-JSON response');
                    }
                    return r.json();
                })
                .then(data => {
                    let html = '';
                    data.images.forEach(img => {
                        const primaryClass = img.is_primary ? 'primary' : '';
                        const starIcon = img.is_primary
                            ? '<span class="material-symbols-outlined" style="position: absolute; top: 4px; left: 4px; font-size: 14px; color: #000;">star</span>'
                            : '';

                        html += '<div class="image-preview ' + primaryClass + '" data-image-id="' + img.id + '">';
                        html += '<img src="' + img.url + '" alt="Product image" loading="lazy">';
                        html += starIcon;
                        html += '<button type="button" class="remove-btn" title="Delete image" data-image-id="' + img.id + '">';
                        html += '<span class="material-symbols-outlined" style="font-size: 14px;">close</span>';
                        html += '</button>';
                        html += '</div>';
                    });
                    previewContainer.innerHTML = html;

                    attachServerImageEvents();
                })
                .catch(err => console.error('Load images error:', err));
        }

        function attachServerImageEvents() {
            if (!config.indexUrl) return;

            previewContainer.querySelectorAll('.image-preview').forEach(preview => {
                const imageId = parseInt(preview.dataset.imageId);

                preview.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-btn')) return;

                    fetch(config.primaryUrl(imageId), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                        .then(r => {
                            const contentType = r.headers.get('content-type') || '';
                            if (!contentType.includes('application/json')) {
                                throw new Error('Server returned non-JSON response');
                            }
                            return r.json();
                        })
                        .then(data => {
                            if (data.success) {
                                loadServerImages();
                            }
                        })
                        .catch(err => console.error('Set primary error:', err));
                });

                const removeBtn = preview.querySelector('.remove-btn');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();

                        if (!confirm('Are you sure you want to delete this image?')) return;

                        fetch(config.deleteUrl(imageId), {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        })
                            .then(r => {
                                const contentType = r.headers.get('content-type') || '';
                                if (!contentType.includes('application/json')) {
                                    throw new Error('Server returned non-JSON response');
                                }
                                return r.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    loadServerImages();
                                }
                            })
                            .catch(err => console.error('Delete image error:', err));
                    });
                }
            });
        }

        uploadZone.addEventListener('click', () => fileInput.click());

        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);

            if (hasProduct) {
                fileInput.value = '';
            }
        });

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
            if (hasProduct) {
                this.value = '';
            }
        });

        if (hasProduct) {
            attachServerImageEvents();
        }
    }
};
