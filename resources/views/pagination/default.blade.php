@if ($paginator->hasPages())
  <div style="display:flex; align-items:center; justify-content:center; gap:6px; flex-wrap:wrap; margin-top:48px;">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
      <span style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#6b5f7c; border:1px solid rgba(91,26,138,.15); padding:10px 20px; background:rgba(18,8,32,.4); cursor:default;">« PREV</span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#b8aece; border:1px solid rgba(91,26,138,.3); padding:10px 20px; background:rgba(18,8,32,.8); text-decoration:none; transition:all .3s;" onmouseover="this.style.borderColor='#c084fc';this.style.color='#c9a84c'" onmouseout="this.style.borderColor='rgba(91,26,138,.3)';this.style.color='#b8aece'">« PREV</a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <span style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#6b5f7c; border:1px solid rgba(91,26,138,.15); padding:10px 16px; background:rgba(18,8,32,.4);">...</span>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#c9a84c; border:1px solid #c9a84c; padding:10px 16px; background:rgba(42,14,80,.4);">{{ $page }}</span>
          @else
            <a href="{{ $url }}" style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#b8aece; border:1px solid rgba(91,26,138,.3); padding:10px 16px; background:rgba(18,8,32,.8); text-decoration:none;" onmouseover="this.style.borderColor='#c084fc';this.style.color='#c9a84c';this.style.background='rgba(42,14,80,.3)'" onmouseout="this.style.borderColor='rgba(91,26,138,.3)';this.style.color='#b8aece';this.style.background='rgba(18,8,32,.8)'">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#b8aece; border:1px solid rgba(91,26,138,.3); padding:10px 20px; background:rgba(18,8,32,.8); text-decoration:none;" onmouseover="this.style.borderColor='#c084fc';this.style.color='#c9a84c'" onmouseout="this.style.borderColor='rgba(91,26,138,.3)';this.style.color='#b8aece'">NEXT »</a>
    @else
      <span style="font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:#6b5f7c; border:1px solid rgba(91,26,138,.15); padding:10px 20px; background:rgba(18,8,32,.4); cursor:default;">NEXT »</span>
    @endif

  </div>
@endif