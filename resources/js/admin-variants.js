window.AdminVariants = {
    init(config) {
        const sizes = config.sizes || [];
        const colors = config.colors || [];
        const existingVariants = config.existingVariants || {};
        const form = document.querySelector(config.formSelector || 'form');

        let selectedSizes = [];
        let selectedColors = [];
        let variantData = {};

        function renderSizePanel() {
            const panel = document.getElementById('size-panel');
            if (!panel) return;

            let html = '<div class="flex flex-wrap gap-2">';
            sizes.forEach(size => {
                const isSelected = selectedSizes.includes(size.id);
                html += '<button type="button" class="size-pill' + (isSelected ? ' selected' : '') + '" data-size-id="' + size.id + '">' + size.name + '</button>';
            });
            html += '</div>';
            html += '<button type="button" id="add-manual-size" class="admin-btn admin-btn-secondary admin-btn-sm mt-3">' +
                '<span class="material-symbols-outlined" style="font-size: 16px;">add</span> Add New Size' +
            '</button>';
            html += '<div id="manual-size-input" class="hidden mt-3">' +
                '<div class="flex gap-2">' +
                    '<input type="text" id="new-size-name" placeholder="Size name (e.g., XXL)" class="admin-form-input" style="max-width: 200px;">' +
                    '<button type="button" id="create-size-btn" class="admin-btn admin-btn-primary admin-btn-sm">Add</button>' +
                    '<button type="button" id="cancel-size-btn" class="admin-btn admin-btn-secondary admin-btn-sm">Cancel</button>' +
                '</div>' +
                '<p class="text-xs text-muted-foreground mt-1">New sizes are added to the global size list.</p>' +
                '</div>';

            panel.innerHTML = html;

            panel.querySelectorAll('.size-pill').forEach(pill => {
                pill.addEventListener('click', function() {
                    saveCurrentMatrixData();
                    const sizeId = parseInt(this.dataset.sizeId);
                    if (selectedSizes.includes(sizeId)) {
                        selectedSizes = selectedSizes.filter(id => id !== sizeId);
                    } else {
                        selectedSizes.push(sizeId);
                    }
                    renderSizePanel();
                    generateMatrix();
                });
            });

            const addManualSize = document.getElementById('add-manual-size');
            const manualInput = document.getElementById('manual-size-input');
            const newNameInput = document.getElementById('new-size-name');
            const createBtn = document.getElementById('create-size-btn');
            const cancelBtn = document.getElementById('cancel-size-btn');

            if (addManualSize) {
                addManualSize.addEventListener('click', () => {
                    manualInput.classList.remove('hidden');
                });
            }
            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => {
                    manualInput.classList.add('hidden');
                    newNameInput.value = '';
                });
            }
            if (createBtn) {
                createBtn.addEventListener('click', () => {
                    const name = newNameInput.value.trim();
                    if (!name) return;
                    fetch(config.createSizeUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ name: name, sort_order: 0 })
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                sizes.push(data.size);
                                saveCurrentMatrixData();
                                selectedSizes.push(data.size.id);
                                newNameInput.value = '';
                                manualInput.classList.add('hidden');
                                renderSizePanel();
                                generateMatrix();
                            }
                        });
                });
            }
        }

        function renderColorPanel() {
            const panel = document.getElementById('color-panel');
            if (!panel) return;

            let html = '<div class="flex flex-wrap gap-2">';
            colors.forEach(color => {
                const isSelected = selectedColors.includes(color.id);
                const swatch = color.hex_code ? '<span class="color-swatch" style="background-color: #' + color.hex_code.replace('#', '') + ';"></span>' : '';
                html += '<button type="button" class="color-pill' + (isSelected ? ' selected' : '') + '" data-color-id="' + color.id + '">' +
                    swatch + color.name +
                    '</button>';
            });
            html += '</div>';
            html += '<button type="button" id="add-manual-color" class="admin-btn admin-btn-secondary admin-btn-sm mt-3">' +
                '<span class="material-symbols-outlined" style="font-size: 16px;">add</span> Add New Color' +
            '</button>';
            html += '<div id="manual-color-input" class="hidden mt-3">' +
                '<div class="flex gap-2 items-end">' +
                    '<div class="admin-form-group">' +
                        '<label class="admin-form-label">Name</label>' +
                        '<input type="text" id="new-color-name" placeholder="Color name" class="admin-form-input" style="max-width: 150px;">' +
                    '</div>' +
                    '<div class="admin-form-group">' +
                        '<label class="admin-form-label">Hex Code</label>' +
                        '<div class="flex gap-2">' +
                            '<input type="color" id="new-color-hex" value="#000000" style="width: 50px; height: 36px; padding: 0; border: 1px solid #ddd; border-radius: 6px;">' +
                            '<input type="text" id="new-color-hex-text" value="#000000" class="admin-form-input" style="max-width: 100px;">' +
                        '</div>' +
                    '</div>' +
                    '<button type="button" id="create-color-btn" class="admin-btn admin-btn-primary admin-btn-sm">Add</button>' +
                    '<button type="button" id="cancel-color-btn" class="admin-btn admin-btn-secondary admin-btn-sm">Cancel</button>' +
                '</div>' +
                '<p class="text-xs text-muted-foreground mt-1">New colors are added to the global color list.</p>' +
                '</div>';

            panel.innerHTML = html;

            panel.querySelectorAll('.color-pill').forEach(pill => {
                pill.addEventListener('click', function() {
                    saveCurrentMatrixData();
                    const colorId = parseInt(this.dataset.colorId);
                    if (selectedColors.includes(colorId)) {
                        selectedColors = selectedColors.filter(id => id !== colorId);
                    } else {
                        selectedColors.push(colorId);
                    }
                    renderColorPanel();
                    generateMatrix();
                });
            });

            const addBtn = document.getElementById('add-manual-color');
            const manualInput = document.getElementById('manual-color-input');
            const nameInput = document.getElementById('new-color-name');
            const hexInput = document.getElementById('new-color-hex');
            const hexTextInput = document.getElementById('new-color-hex-text');
            const createBtn = document.getElementById('create-color-btn');
            const cancelBtn = document.getElementById('cancel-color-btn');

            if (addBtn) {
                addBtn.addEventListener('click', () => manualInput.classList.remove('hidden'));
            }
            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => {
                    manualInput.classList.add('hidden');
                    nameInput.value = '';
                });
            }
            if (hexInput && hexTextInput) {
                hexInput.addEventListener('input', () => { hexTextInput.value = hexInput.value; });
                hexTextInput.addEventListener('input', () => {
                    if (/^#[0-9A-Fa-f]{6}$/.test(hexTextInput.value)) hexInput.value = hexTextInput.value;
                });
            }
            if (createBtn) {
                createBtn.addEventListener('click', () => {
                    const name = nameInput.value.trim();
                    const hex = hexTextInput.value.trim();
                    if (!name) return;
                    fetch(config.createColorUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ name: name, hex_code: hex || null })
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                colors.push(data.color);
                                saveCurrentMatrixData();
                                selectedColors.push(data.color.id);
                                nameInput.value = '';
                                manualInput.classList.add('hidden');
                                renderColorPanel();
                                generateMatrix();
                            }
                        });
                });
            }
        }

        function saveCurrentMatrixData() {
            const rows = document.querySelectorAll('#variants-matrix-table tbody tr');
            rows.forEach(row => {
                const sizeId = parseInt(row.dataset.sizeId);
                const colorId = parseInt(row.dataset.colorId);
                const key = sizeId + '_' + colorId;

                const sku = row.querySelector('input[name*="[sku]"]')?.value || '';
                const stock = row.querySelector('input[name*="[stock]"]')?.value || 0;
                const priceOverride = row.querySelector('input[name*="[price_override]"]')?.value || '';
                const salePriceOverride = row.querySelector('input[name*="[sale_price_override]"]')?.value || '';
                const isActive = row.querySelector('input[name*="[is_active]"]')?.checked ? 1 : 0;

                variantData[key] = {
                    sku: sku,
                    stock: stock,
                    price_override: priceOverride,
                    sale_price_override: salePriceOverride,
                    is_active: isActive === 1 ? true : false,
                };
            });
        }

        function getSizeName(id) {
            const size = sizes.find(s => s.id === id);
            return size ? size.name : id;
        }

        function getColorInfo(id) {
            const color = colors.find(c => c.id === id);
            return color ? { name: color.name, hex_code: color.hex_code } : { name: id, hex_code: null };
        }

        function sortSelectedSizes() {
            selectedSizes.sort((a, b) => {
                const ai = sizes.findIndex(s => s.id === a);
                const bi = sizes.findIndex(s => s.id === b);
                return ai - bi;
            });
        }

        function sortSelectedColors() {
            selectedColors.sort((a, b) => {
                const ai = colors.findIndex(c => c.id === a);
                const bi = colors.findIndex(c => c.id === b);
                return ai - bi;
            });
        }

        function generateMatrix() {
            sortSelectedSizes();
            sortSelectedColors();

            const matrixContainer = document.getElementById('variants-matrix');
            if (!matrixContainer) return;

            if (selectedSizes.length === 0 && selectedColors.length === 0) {
                matrixContainer.innerHTML = '<p class="text-sm text-muted-foreground py-4">Select size and color options above to generate variants.</p>';
                return;
            }

            if (selectedSizes.length === 0 || selectedColors.length === 0) {
                matrixContainer.innerHTML = '<p class="text-sm text-warning py-4">Select at least one size and one color to generate variants.</p>';
                return;
            }

            let html = '<table class="admin-table" id="variants-matrix-table">';
            html += '<thead><tr>';
            html += '<th>Size</th>';
            html += '<th>Color</th>';
            html += '<th>SKU</th>';
            html += '<th>Stock</th>';
            html += '<th>Price Override</th>';
            html += '<th>Sale Price Override</th>';
            html += '<th>Active</th>';
            html += '</tr></thead>';
            html += '<tbody>';

            let index = 0;

            selectedSizes.forEach(sizeId => {
                selectedColors.forEach(colorId => {
                    const key = sizeId + '_' + colorId;
                    const existing = variantData[key] || {};
                    const sizeInfo = getSizeName(sizeId);
                    const colorInfo = getColorInfo(colorId);
                    const swatch = colorInfo.hex_code ? 'background-color: #' + colorInfo.hex_code.replace('#', '') + ';' : '';

                    html += '<tr class="variant-row" data-size-id="' + sizeId + '" data-color-id="' + colorId + '">';
                    html += '<td><input type="hidden" name="variants[' + index + '][size_id]" value="' + sizeId + '"><input type="hidden" name="variants[' + index + '][color_id]" value="' + colorId + '"></td>';
                    html += '<td>' + sizeInfo + '</td>';
                    html += '<td><div class="flex items-center gap-2">' +
                        (colorInfo.hex_code ? '<span class="w-4 h-4 rounded-full" style="border: 1px solid #ccc; ' + swatch + '"></span>' : '') +
                        colorInfo.name +
                        '</div></td>';
                    html += '<td><input type="text" name="variants[' + index + '][sku]" value="' + (existing.sku || '') + '" class="admin-form-input" style="width: 140px;" placeholder="Auto or manual"></td>';
                    html += '<td><input type="number" name="variants[' + index + '][stock]" min="0" value="' + (existing.stock !== undefined ? existing.stock : 0) + '" class="admin-form-input" style="width: 100px;"></td>';
                    html += '<td><input type="number" name="variants[' + index + '][price_override]" step="0.01" value="' + (existing.price_override || '') + '" class="admin-form-input" style="width: 120px;" placeholder="Optional"></td>';
                    html += '<td><input type="number" name="variants[' + index + '][sale_price_override]" step="0.01" value="' + (existing.sale_price_override || '') + '" class="admin-form-input" style="width: 120px;" placeholder="Optional"></td>';
                    html += '<td><input type="checkbox" name="variants[' + index + '][is_active]" value="1" ' + (existing.is_active !== false ? 'checked' : '') + ' class="admin-form-input" style="width: auto;"></td>';
                    html += '</tr>';

                    index++;
                });
            });

            html += '</tbody></table>';
            matrixContainer.innerHTML = html;
            generateHiddenSelectedOptions();
        }

        function generateHiddenSelectedOptions() {
            let html = '';
            selectedSizes.forEach(sizeId => {
                html += '<input type="hidden" name="selected_sizes[]" value="' + sizeId + '">';
            });
            selectedColors.forEach(colorId => {
                html += '<input type="hidden" name="selected_colors[]" value="' + colorId + '">';
            });
            const hiddenContainer = document.getElementById('variants-hidden-inputs');
            if (hiddenContainer) {
                hiddenContainer.innerHTML = html;
            }
        }

        function initFromExisting() {
            Object.keys(existingVariants).forEach(key => {
                const parts = key.split('_');
                const sizeId = parseInt(parts[0]);
                const colorId = parseInt(parts[1]);

                if (!selectedSizes.includes(sizeId)) selectedSizes.push(sizeId);
                if (!selectedColors.includes(colorId)) selectedColors.push(colorId);

                variantData[key] = existingVariants[key];
            });
        }

        if (Object.keys(existingVariants).length > 0) {
            initFromExisting();
        }

        renderSizePanel();
        renderColorPanel();
        generateMatrix();
        generateHiddenSelectedOptions();

        // Update hidden inputs on form submit
        form.addEventListener('submit', function() {
            saveCurrentMatrixData();
            generateHiddenSelectedOptions();
        });
    }
};
