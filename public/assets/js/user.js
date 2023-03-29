var statusCheckChecked = document.querySelectorAll(".statusCheckChecked");
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let url = '/user/masyarakat/status';

statusCheckChecked.forEach((el) => {
    el.addEventListener('change', function (e) {
        const userId = e.target.getAttribute('data-user-id');
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
                    user_id: userId
                })
            })
            .then((data) => {
                
            })
            .catch(function (error) {
                console.log(error);
            });
    })
})
