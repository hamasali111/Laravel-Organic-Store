@extends('layouts.admin')

@section('title', 'Categories — Admin')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">
        Categories
    </h1>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        + Add Category
    </a>
</div>

@if(session('success'))
    <div style="
        background:#e6f4ea;
        color:#2d6a4f;
        padding:12px 16px;
        border-radius:8px;
        margin-bottom:16px;
        font-size:.87rem">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="admin-card">

    <table class="data-table">

        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse ($categories as $cat)

            <tr>

                {{-- IMAGE --}}
                <td>
                    <img
                        src="{{ $cat->image_url }}"
                        alt="{{ $cat->name }}"
                        style="
                            width:48px;
                            height:48px;
                            border-radius:8px;
                            object-fit:cover;
                        "
                        onerror="
                            this.style.display='none';
                            this.nextElementSibling.style.display='flex';
                        "
                    >
                    <div style="
                        display:none;
                        width:48px;
                        height:48px;
                        background:var(--green-pale);
                        border-radius:8px;
                        align-items:center;
                        justify-content:center;
                    ">
                        🌿
                    </div>
                </td>

                {{-- NAME --}}
                <td>
                    <strong>{{ $cat->name }}</strong>
                </td>

                {{-- SLUG --}}
                <td style="color:var(--muted);font-size:.82rem">
                    {{ $cat->slug }}
                </td>

                {{-- PRODUCT COUNT --}}
                <td>
                    {{ $cat->products_count }}
                </td>

                {{-- ACTIONS --}}
                <td>

                    <div style="display:flex;gap:6px">

                        <a href="{{ route('admin.categories.edit', $cat->id) }}"
                           class="btn btn-sm btn-outline">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.categories.destroy', $cat->id) }}"
                              onsubmit="return confirm('Delete this category?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5"
                    style="
                        text-align:center;
                        padding:32px;
                        color:var(--muted)
                    ">

                    No categories yet.

                    <a href="{{ route('admin.categories.create') }}">
                        Add one
                    </a>.

                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <div style="margin-top:20px">
        {{ $categories->links() }}
    </div>

</div>

@endsection
