const checkbox = document.getElementById("select_all");

const check_masyarakat = document.querySelectorAll(".check-masyarakat");

checkbox.addEventListener("change", function (element) {
    check_masyarakat.forEach((item) => {
        item.checked = checkbox.checked;
    });
});
