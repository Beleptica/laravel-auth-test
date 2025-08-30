<div class="w-full bg-yellow-200 text-yellow-900">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
        <div>You are impersonating: {{ auth()->user()->username }}</div>
        <form method="POST" action="{{ route('impersonate.stop') }}">
            @csrf
            <button type="submit" class="underline">Return to admin</button>
        </form>
    </div>
</div>
