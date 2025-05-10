<form action="{{ route('login') }}" method="POST">
    @csrf
    <div>
        <input type="text" name="identifier" placeholder="NIM/NIP" required>
    </div>
    <div>
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit">Login</button>
</form>
