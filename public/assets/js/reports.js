window.addEventListener("load", function () {
    const selectPemungut = document.getElementById("select_pemungut");
    const inputPrice = document.getElementById("price");
    const priceHidden = document.getElementById("price-hidden");

    selectPemungut.addEventListener("change", function (e) {
        const option = selectPemungut.querySelector(
            `[value*='${e.target.value}']`
        );
        const price = option.getAttribute("data-price") ?? 0;

        inputPrice.value = priceFormat(+price);
        priceHidden.value = priceFormat(+price);
    });
});

function priceFormat(price) {
    const formattedPrice = price.toLocaleString("id-ID", {
        maximumFractionDigits: 2,
        minimumFractionDigits: 2,
    });

    return formattedPrice;
}
