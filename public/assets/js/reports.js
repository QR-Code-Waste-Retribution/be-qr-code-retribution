window.addEventListener("load", function () {
    const selectPemungut = document.getElementById('select_pemungut');
    const inputPrice = document.getElementById('price');

    selectPemungut.addEventListener('change', function(e) { 
        const option = selectPemungut.querySelector(`[value*='${e.target.value}']`);
        const price = option.getAttribute('data-price') ?? 0;

        inputPrice.value = price;
    })
});
