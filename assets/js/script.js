document.getElementById("myForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(event.target);

    fetch('/update_profile', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log(data);
            let alertMessageWrapper = document.querySelector('.alert-messages');
            if (data == 'success') {
                alertMessageWrapper.style.display = 'block';

                setTimeout(() => {
                    alertMessageWrapper.style.display = 'none';
                    window.location.reload(false);
                }, 4000);
            }

        })
        .catch(error => {
            console.error('Fetch Error:', error);
        });
});