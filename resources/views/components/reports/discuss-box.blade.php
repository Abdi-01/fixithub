@props([
'reportId',
'reportStatus',
'discussionMessages' => []
])

<div class="relative">
    <div id="cheat-message" class="h-96 overflow-y-auto border border-gray-200 shadow mb-2 rounded-sm">
        @forelse($discussionMessages as $message)
        <p class="text-xs m-1"><span class="text-gray-400">{{ explode('@', $message['email'])[0] }}</span> {{ $message['message'] }} </p>
        @empty
        @endforelse
    </div>
    @if(session('user'))
    <form action="{{ route('discussion.submit', ['slug' => $reportId ]) }}" method="POST" class="mx-auto">
        @csrf
        @if($reportStatus !== 'Solved')
        <div class="flex items-center justify-between gap-2">
            <input id="message" name="message" placeholder="Tuliskan pesan" class="p-2 border border-gray-200 rounded-full" />
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Kirim
            </button>
        </div>
        @endif
    </form>
    @else
    <a href="/signin"
        class="block w-full text-blue-700 bg-white shadow border border-blue-300 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Login untuk berdiskusi
    </a>
    @endif
</div>