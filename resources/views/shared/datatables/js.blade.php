<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/2.1.1/jquery.dataTables.min.js" integrity="sha512-CKwcR6t3iAghHw93W7LcmVlSRCoGXiYyjITGKrFyDFqWHt6LIJ3j5f1dSjvL+OJbvG0KvPgP/zBEOikHUIu+3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.1/dataTables.bootstrap5.min.js" integrity="sha512-DK2sDFXaKlL6GyjjmKlL1YsuUiAuEKBqYqj0oYQijZQadPjTunVZYhDCOb8pv5CcIKwoz8ev+wMhJgaQcBN7xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-searchpanes/2.0.2/dataTables.searchPanes.min.js" integrity="sha512-DL8V8XZwWpGudptIvft59Y7wzo1u6qW1Pg3TxDHTvtCwTklvQ1myN6hdiY/kE7lgjesFdMoxFHnb/J84B/obiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-searchpanes-bs5/2.1.0/searchPanes.bootstrap5.min.js" integrity="sha512-vrpQvhWKq7BKsA1TSVDpZ4OAE4EV53YFNyCFjbv+zW+xUndPy50N9OhIEwZa3ScbgEMDoqI7I+67vWa6rYoZxQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons/2.2.3/js/dataTables.buttons.min.js" integrity="sha512-QT3oEXamRhx0x+SRDcgisygyWze0UicgNLFM9Dj5QfJuu2TVyw7xRQfmB0g7Z5/TgCdYKNW15QumLBGWoPefYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs5/2.3.3/buttons.bootstrap5.min.js" integrity="sha512-SvPVJ3mp1un96vaBkmw9+ujlgapdYZKoKPSiHTK2oI5qVN+VTS2ogHezx2rxolWWXMw+jblde/DskM6GSVl8Og==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

{{ $dataTable->scripts() }}

<script type="module">
    const setClasses = () => {
        const buttonsContainer = document.querySelector('.dt-buttons');
        buttonsContainer ? buttonsContainer.classList.add('btn-sm', 'mb-2') : setTimeout(setClasses, 500);
    };
    setClasses();
</script>
