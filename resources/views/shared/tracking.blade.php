<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6VW0C74DTD"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-6VW0C74DTD');
  gtag('event', 'page_view', {
    @if(auth()->user())
      user_id: {{ auth()->id() }},
      user_name: '{{ auth()->user()->name }}',
    @endif
  });
</script>