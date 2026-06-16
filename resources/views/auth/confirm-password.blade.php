<x-guest-layout>
    <div style="text-align:center;margin-bottom:24px">
        <div style="font-size:2rem;margin-bottom:8px">🔒</div>
        <h1 style="font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--green);margin-bottom:8px">Confirm Password</h1>
        <p style="font-size:.84rem;color:var(--muted)">This is a secure area. Please confirm your password to continue.</p>
    </div>
    @if($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn-submit">Confirm</button>
    </form>
</x-guest-layout>
