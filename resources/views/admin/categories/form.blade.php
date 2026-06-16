@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@push('styles')
<style>
.image-preview-wrap {
    position: relative;
    display: inline-block;
}
.image-preview-wrap img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid var(--border);
}
.upload-tabs {
    display: flex;
    gap: 0;
    margin-bottom: 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
    width: fit-content;
}
.upload-tab {
    padding: 7px 18px;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    background: var(--bg);
    color: var(--muted);
}
.upload-tab.active {
    background: var(--green);
    color: white;
}
.upload-panel {
    display: none;
}
.upload-panel.active {
    display: block;
}
.drop-zone {
    border: 2px dashed var(--border);
    border-radius: 10px;
    padding: 28px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s;
}
.drop-zone:hover,
.drop-zone.drag {
    border-color: var(--green);
    background: var(--green-xpale);
}
</style>
@endpush

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">
        {{ isset($category) ? 'Edit Category' : 'Add Category' }}
    </h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-gray">← Back</a>
</div>

<div class="admin-card" style="max-width:600px">

    <form method="POST"
        action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
        enctype="multipart/form-data">

        @csrf
        @if(isset($category)) @method('PUT') @endif

        <!-- NAME -->
        <div class="form-group">
            <label class="form-label">Name *</label>
            <input type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $category->name ?? '') }}"
                required>
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <!-- IMAGE -->
        <div class="form-group">
            <label class="form-label">Category Image</label>

            <!-- PREVIEW -->
            @php
                $existingImage = null;
                if (isset($category) && $category->image) {
                    $existingImage = $category->image_url;
                }
                $isStoredImage = isset($category) && $category->image && str_starts_with($category->image, '/storage/');
            @endphp

            <img src="{{ $existingImage ?? '' }}"
                alt="Image Preview"
                id="img-preview"
                style="{{ $existingImage ? 'display:block' : 'display:none' }};width:120px;height:120px;object-fit:cover;border-radius:10px;border:2px solid var(--border);margin-bottom:12px"
                onerror="this.style.display='none'">

            @if($existingImage)
                <div style="font-size:.76rem;color:var(--muted);margin-bottom:10px">Current Image</div>
            @endif

            <!-- TABS -->
            <div class="upload-tabs">
                <button type="button" class="upload-tab active" onclick="switchTab('upload')">📁 Upload File</button>
                <button type="button" class="upload-tab" onclick="switchTab('url')">🔗 Image URL</button>
            </div>

            <!-- FILE UPLOAD PANEL -->
            <div class="upload-panel active" id="tab-upload">
                <div class="drop-zone" id="drop-zone" onclick="document.getElementById('image_upload').click()">
                    <input type="file"
                        name="image_upload"
                        id="image_upload"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        style="display:none"
                        onchange="previewFile(this)">
                    <div id="drop-zone-content">
                        <div style="font-size:2rem;margin-bottom:8px">🖼️</div>
                        <div style="font-size:.88rem;font-weight:600;color:var(--text)">Click to upload or drag & drop</div>
                        <div style="font-size:.78rem;color:var(--muted);margin-top:4px">JPG, PNG, WebP — max 4MB</div>
                    </div>
                </div>
            </div>

            <!-- IMAGE URL PANEL -->
            <div class="upload-panel" id="tab-url">
                <input type="url"
                    name="image"
                    id="image-url-input"
                    class="form-control"
                    value="{{ old('image', !$isStoredImage ? ($category->image ?? '') : '') }}"
                    placeholder="https://example.com/image.jpg"
                    oninput="previewUrl(this)">
                <div style="font-size:.76rem;color:var(--muted);margin-top:4px">Paste a direct image URL</div>
            </div>

        </div>

        @if($errors->any())
            <div style="background:#fde8e8;color:var(--red);padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.87rem">
                @foreach($errors->all() as $e)
                    <div>• {{ $e }}</div>
                @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary">
            {{ isset($category) ? 'Update Category' : 'Create Category' }}
        </button>

    </form>
</div>

<script>
// ── Tab switching ─────────────────────────────────────────────
function switchTab(tab) {
    document.querySelectorAll('.upload-tab').forEach((t, i) =>
        t.classList.toggle('active',
            (i === 0 && tab === 'upload') || (i === 1 && tab === 'url')
        )
    );
    document.getElementById('tab-upload').classList.toggle('active', tab === 'upload');
    document.getElementById('tab-url').classList.toggle('active', tab === 'url');

    if (tab === 'upload') {
        document.getElementById('image-url-input').value = '';
    } else {
        document.getElementById('image_upload').value = '';
        resetDropZone();
        previewUrl(document.getElementById('image-url-input'));
    }
}

// ── File preview ──────────────────────────────────────────────
function previewFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('img-preview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);

        document.getElementById('drop-zone-content').innerHTML =
            '<div style="font-size:1.5rem">✅</div>' +
            '<div style="font-size:.85rem;font-weight:600;color:var(--green)">' + input.files[0].name + '</div>';
    }
}

// ── URL preview ───────────────────────────────────────────────
function previewUrl(input) {
    const img = document.getElementById('img-preview');
    if (input.value.trim()) {
        img.src = input.value.trim();
        img.style.display = 'block';
        img.onerror = () => { img.style.display = 'none'; };
        img.onload  = () => { img.onerror = null; };
    } else {
        img.style.display = 'none';
        img.src = '';
    }
}

// ── Reset drop zone UI ────────────────────────────────────────
function resetDropZone() {
    document.getElementById('drop-zone-content').innerHTML =
        '<div style="font-size:2rem;margin-bottom:8px">🖼️</div>' +
        '<div style="font-size:.88rem;font-weight:600;color:var(--text)">Click to upload or drag & drop</div>' +
        '<div style="font-size:.78rem;color:var(--muted);margin-top:4px">JPG, PNG, WebP — max 4MB</div>';
}

// ── Drag & drop ───────────────────────────────────────────────
const dz = document.getElementById('drop-zone');
if (dz) {
    dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('drag'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('drag'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('drag');
        const fi = document.getElementById('image_upload');
        fi.files = e.dataTransfer.files;
        previewFile(fi);
    });
}
</script>

@endsection
