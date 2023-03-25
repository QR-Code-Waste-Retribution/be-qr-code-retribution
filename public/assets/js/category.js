var statusCheckChecked = document.querySelectorAll(".statusCheckChecked");
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let url = '/category/status';

statusCheckChecked.forEach((el) => {
    el.addEventListener('change', function (e) {
        const categoryId = e.target.getAttribute('data-category-id');
        const spinner = document.getElementById(`spinnder-border-${categoryId}`);
        const text = document.getElementById(`text-status-${categoryId}`);
        el.parentElement.classList.add('d-none');
        text.classList.add('d-none');
        spinner.classList.remove('d-none');
        fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    category_id: categoryId
                })
            })
            .then((data) => {
                el.parentElement.classList.remove('d-none');
                spinner.classList.add('d-none');
                text.classList.remove('d-none');
                text.innerText = el.checked ? 'Active' : 'Inactive';
            })
            .catch(function (error) {
                console.log(error);
            });
    })
})
