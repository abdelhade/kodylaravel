<li class="tree">
    <span class="caret">{{ $account->code }}--{{ $account->aname }}</span>
    @if(isset($account->children) && count($account->children) > 0)
        <ul class="nested">
            @foreach($account->children as $child)
                @include('accounting::accounts.partials.tree-item', ['account' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
