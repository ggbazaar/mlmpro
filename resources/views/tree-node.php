<div class="tree-node p-4 cursor-pointer" onclick="showPopup('{{ $node['value'] }}')">
    <div class="bg-gray-200 hover:bg-gray-300 p-2 rounded-lg">
        {{ $node['value'] }}
    </div>
    <div class="flex justify-between">
        @if (isset($node['left']))
            <div class="ml-4">
                @include('partials.tree-node', ['node' => $node['left']])
            </div>
        @endif
        @if (isset($node['right']))
            <div class="mr-4">
                @include('partials.tree-node', ['node' => $node['right']])
            </div>
        @endif
    </div>
</div>
