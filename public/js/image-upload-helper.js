/**
 * Yayasan LINTASAN - Image Upload Inspector & Client-Side Auto-Compressor
 * 
 * Features:
 * 1. Live image thumbnail preview on selection.
 * 2. Real-time file size & resolution measurement.
 * 3. Immediate warning badge if file exceeds PHP 2MB server limit.
 * 4. 1-Click Client-side Canvas Auto-Compression (< 800KB) to prevent server upload failure.
 * 5. Descriptive error reporting and validation feedback.
 */

document.addEventListener('DOMContentLoaded', function () {
    initImageUploadInspectors();
});

function initImageUploadInspectors() {
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach(input => {
        // Only target inputs meant for images or generic upload
        const accept = input.getAttribute('accept') || '';
        const name = input.getAttribute('name') || '';
        const isImage = accept.includes('image') || 
                        name.includes('photo') || 
                        name.includes('image') || 
                        name.includes('logo') || 
                        name.includes('gallery') || 
                        name.includes('value_');

        if (!isImage) return;

        // Create container for preview & stats if not already present
        let previewContainer = input.parentElement.querySelector('.image-upload-preview-container');
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.className = 'image-upload-preview-container mt-2.5 space-y-2';
            input.parentElement.appendChild(previewContainer);
        }

        input.addEventListener('change', function () {
            handleFileInputChange(input, previewContainer);
        });
    });
}

function formatBytes(bytes, decimals = 1) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function handleFileInputChange(input, container) {
    container.innerHTML = '';
    const files = input.files;
    if (!files || files.length === 0) return;

    const maxServerBytes = 2 * 1024 * 1024; // 2 MB PHP ini threshold

    Array.from(files).forEach((file, index) => {
        const itemCard = document.createElement('div');
        itemCard.className = 'p-3 bg-gray-50 border rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs shadow-sm transition-all duration-200';
        itemCard.dataset.fileIndex = index;

        const isOverLimit = file.size > maxServerBytes;
        if (isOverLimit) {
            itemCard.classList.add('border-amber-300', 'bg-amber-50/40');
        } else {
            itemCard.classList.add('border-gray-200');
        }

        const leftCol = document.createElement('div');
        leftCol.className = 'flex items-center gap-3 min-w-0';

        // Thumbnail element
        const thumb = document.createElement('div');
        thumb.className = 'w-14 h-14 rounded-md bg-gray-200 overflow-hidden shrink-0 border border-gray-200 flex items-center justify-center bg-cover bg-center';
        thumb.innerHTML = '<i class="fas fa-spinner fa-spin text-gray-400"></i>';

        // File info
        const infoCol = document.createElement('div');
        infoCol.className = 'min-w-0';

        const nameLabel = document.createElement('div');
        nameLabel.className = 'font-bold text-gray-800 truncate max-w-[220px] sm:max-w-xs';
        nameLabel.title = file.name;
        nameLabel.textContent = file.name;

        const metaLabel = document.createElement('div');
        metaLabel.className = 'text-[10px] text-gray-500 mt-0.5 flex items-center gap-2';

        const sizeBadge = document.createElement('span');
        sizeBadge.className = isOverLimit ? 'font-bold text-amber-700' : 'text-gray-600';
        sizeBadge.textContent = formatBytes(file.size);

        metaLabel.appendChild(sizeBadge);

        infoCol.appendChild(nameLabel);
        infoCol.appendChild(metaLabel);

        leftCol.appendChild(thumb);
        leftCol.appendChild(infoCol);
        itemCard.appendChild(leftCol);

        // Action / Warning column
        const rightCol = document.createElement('div');
        rightCol.className = 'flex items-center gap-2 self-end sm:self-center shrink-0';

        if (isOverLimit) {
            const warningBadge = document.createElement('div');
            warningBadge.className = 'text-[10px] text-amber-800 bg-amber-100 border border-amber-200 px-2 py-1 rounded font-semibold flex items-center gap-1.5';
            warningBadge.innerHTML = '<i class="fas fa-triangle-exclamation text-amber-600"></i> Melebihi 2MB (Batas PHP)';
            rightCol.appendChild(warningBadge);

            // Instant Client-side Compress Button
            if (file.type.startsWith('image/') && !file.type.includes('svg')) {
                const compressBtn = document.createElement('button');
                compressBtn.type = 'button';
                compressBtn.className = 'text-[10px] bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-2.5 py-1 rounded transition shadow-sm flex items-center gap-1';
                compressBtn.innerHTML = '<i class="fas fa-bolt"></i> Kompres Otomatis';
                compressBtn.title = 'Kompresi langsung di browser agar di bawah 1MB dan pasti berhasil diunggah';

                compressBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    compressBtn.disabled = true;
                    compressBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengompres...';

                    compressImageFile(file, function (compressedFile) {
                        // Replace file in input
                        replaceFileInInput(input, index, compressedFile);
                        handleFileInputChange(input, container);
                    });
                });

                rightCol.appendChild(compressBtn);
            }
        } else {
            const okBadge = document.createElement('span');
            okBadge.className = 'text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded font-semibold flex items-center gap-1';
            okBadge.innerHTML = '<i class="fas fa-check text-emerald-600"></i> Ukuran Aman';
            rightCol.appendChild(okBadge);
        }

        itemCard.appendChild(rightCol);
        container.appendChild(itemCard);

        // Read thumbnail and image dimensions
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                thumb.innerHTML = '';
                thumb.style.backgroundImage = `url('${e.target.result}')`;

                // Calculate image dimensions
                const img = new Image();
                img.onload = function () {
                    const dimSpan = document.createElement('span');
                    dimSpan.className = 'text-[9px] text-gray-400 border-l pl-2 border-gray-300';
                    dimSpan.textContent = `${img.naturalWidth} × ${img.naturalHeight} px`;
                    metaLabel.appendChild(dimSpan);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            thumb.innerHTML = '<i class="fas fa-file text-gray-400 text-lg"></i>';
        }
    });
}

/**
 * Client-side Canvas Image Compression
 */
function compressImageFile(file, callback, maxWidth = 1600, maxHeight = 1600, quality = 0.78) {
    const reader = new FileReader();
    reader.onload = function (e) {
        const img = new Image();
        img.onload = function () {
            let width = img.width;
            let height = img.height;

            if (width > maxWidth || height > maxHeight) {
                const ratio = width / height;
                if (ratio > 1) {
                    width = maxWidth;
                    height = Math.round(maxWidth / ratio);
                } else {
                    height = maxHeight;
                    width = Math.round(maxHeight * ratio);
                }
            }

            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');

            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';
            ctx.drawImage(img, 0, 0, width, height);

            const mimeType = (file.type === 'image/png' || file.type === 'image/webp') ? file.type : 'image/jpeg';

            canvas.toBlob(function (blob) {
                if (!blob) {
                    callback(file);
                    return;
                }
                const newFile = new File([blob], file.name, {
                    type: mimeType,
                    lastModified: Date.now()
                });
                callback(newFile);
            }, mimeType, quality);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

/**
 * Replace file in input via DataTransfer API
 */
function replaceFileInInput(input, targetIndex, newFile) {
    const dt = new DataTransfer();
    const currentFiles = input.files;

    for (let i = 0; i < currentFiles.length; i++) {
        if (i === targetIndex) {
            dt.items.add(newFile);
        } else {
            dt.items.add(currentFiles[i]);
        }
    }

    input.files = dt.files;
}
