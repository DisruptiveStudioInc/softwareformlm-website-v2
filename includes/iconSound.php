<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <style type="text/css">
    .sound-line{
      --line-base: 12%;
      transform-origin: center;
      transform: scaleY(var(--line-base));
      transition: transform 300ms linear;
    }
    .active .sound-line{
      animation: scaleLine 2s linear infinite;
    }
    .sl-1{
      --line-1:60%;
      --line-2:20%;
      --line-3:45%;
      animation-delay: 100ms
    }
    .sl-2{
      --line-1:80%;
      --line-2:43%;
      --line-3:64%;
      animation-delay: 300ms;
    }
    .sl-3{
      --line-1:50%;
      --line-2:18%;
      --line-3:100%;
    }
    .sl-4{
      --line-1:76%;
      --line-2:32%;
      --line-3:52%;
      animation-delay: 250ms;
    }
    .sl-5{
      --line-1:35%;
      --line-2:14%;
      --line-3:64%;
      animation-delay: 175ms;
    }
    @keyframes scaleLine{
      to, from{
        transform: scaleY(var(--line-base));
      }
      25%{
        transform: scaleY(var(--line-1));
      }
      50%{
        transform: scaleY(var(--line-2));
      }
      75%{
        transform: scaleY(var(--line-3));
      }
    }
  </style>
  <line class="sound-line sl-1" x1="4" y1="3" x2="4" y2="21" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/>
  <line class="sound-line sl-2" x1="8" y1="3" x2="8" y2="21" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/>
  <line class="sound-line sl-3" x1="12" y1="3" x2="12" y2="21" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/>
  <line class="sound-line sl-4" x1="16" y1="3" x2="16" y2="21" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/>
  <line class="sound-line sl-5" x1="20" y1="3" x2="20" y2="21" stroke="currentcolor" stroke-width="2" stroke-linecap="round"/>
</svg>
