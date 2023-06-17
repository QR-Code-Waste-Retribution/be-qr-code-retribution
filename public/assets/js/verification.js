window.addEventListener("load", function () {
    let selectedMasyarakat = [];

    const checkboxAll = document.getElementById("select_all");
    const checkMasyarakat = Array.from(
        document.querySelectorAll(".check-masyarakat")
    );
    const selectedMasyarakatId = document.getElementById(
        "selected-masyarakat-id"
    );
    const button_save = document.getElementById(
        "button_save"
    );

    checkMasyarakat.forEach((el) => {
        el.addEventListener("change", function () {
            const id = el.getAttribute("data-id");

            if (el.checked) {
                selectedMasyarakat.push(id);
            } else {
                selectedMasyarakat = selectedMasyarakat.filter(
                    (el) => el !== id
                );
            }

            setValueInput(selectedMasyarakat);
        });
    });

    function setValueInput(arr) {
        if(arr.length <= 0){
            button_save.classList.add('disabled')
        } else {
            button_save.classList.remove('disabled')
        }
        selectedMasyarakatId.value = JSON.stringify(arr.length > 0 ? arr : '');
    }

    checkboxAll.addEventListener("change", function () {
        checkMasyarakat.forEach((item) => {
            item.checked = checkboxAll.checked;

            if (checkboxAll.checked) {
                selectedMasyarakat = [item.getAttribute("data-id")];
            } else {
                selectedMasyarakat = [];
            }
        });
        setValueInput(selectedMasyarakat);
    });
});
