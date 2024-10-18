@extends('layouts.app')

@section('content')




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Binary Tree View</div>
                 <div class="card-body">
                    <div class="flex justify-center">
                        <div class="tree L11">
                            @include('partials.tree-node', ['node' => $tree])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->
<div id="popup" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold" id="popup-title"></h2>
        <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded" onclick="closePopup()">Close</button>
    </div>
</div>

<script>
    function showPopup(title) {
        document.getElementById('popup-title').innerText = title;
        document.getElementById('popup').classList.remove('hidden');
    }

    function closePopup() {
        document.getElementById('popup').classList.add('hidden');
    }
</script>
@endsection
