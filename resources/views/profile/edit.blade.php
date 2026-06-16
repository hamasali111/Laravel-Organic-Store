@extends('layouts.app')
@section('title', 'My Profile — Organic Store')
@push('styles')
<style>
.profile-wrap{max-width:720px;margin:40px auto;padding:0 24px}
.profile-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:30px;margin-bottom:22px}
.profile-card h2{font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:600px){.form-row{grid-template-columns:1fr}}
</style>
@endpush
@section('content')
<div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>›</span>My Profile</div>
<div class="profile-wrap">

    <div class="profile-card">
        <h2>Profile Information</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Optional">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Default Address</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Your shipping address">{{ old('address', auth()->user()->address) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <div class="profile-card">
        <h2>Change Password</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" required autocomplete="current-password">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>

    <div class="profile-card" style="border-color:#fca5a5">
        <h2 style="color:var(--red)">Danger Zone</h2>
        <p style="font-size:.88rem;color:var(--muted);margin-bottom:16px">Once you delete your account, all data will be permanently removed.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure? This action cannot be undone.')">
            @csrf @method('DELETE')
            <div class="form-group">
                <label class="form-label">Confirm your password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>

</div>
@endsection
