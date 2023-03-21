var statusCheckChecked = document.querySelectorAll(".statusCheckChecked");
statusCheckChecked.forEach((el) => {
    el.addEventListener('change', function (e) {
        console.log(e.target.getAttribute('data-id'));
    })
})
