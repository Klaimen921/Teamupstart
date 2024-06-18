document.getElementsByClassName("send-message")[0].addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    let errorMessage = '';
    fetch('/start_chat', {
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
            data = JSON.parse(data);

            if (data.status) {
                document.getElementsByClassName('chat__wrapper')[1].innerHTML += data.data;
            } else {
                errorMessage = 'Error: ' + data.data;
            }

            let alertMessageWrapper = document.querySelector('.alert-messages');
            alertMessageWrapper.style.display = 'block';

            let backgroundAlert = '';
            let textAlert = 'Message send successfully';
            if (errorMessage) {
                backgroundAlert = 'red';
                textAlert       = errorMessage;
            }

            alertMessageWrapper.getElementsByClassName('alert-messages__item')[0].style.background = backgroundAlert;
            alertMessageWrapper.getElementsByClassName('text-on-action')[0].innerHTML = textAlert;

            document.getElementById('write_message').value = '';

            setTimeout(function () {
                alertMessageWrapper.style.display = 'none';
            }, 2500)

        })
        .catch(error => {
            console.error('Fetch Error:', error);
        });
})

setInterval(function () {
    const params = new URLSearchParams(window.location.search)
    const other_user_id = params.get('id')
    let fd = new FormData();
    fd.set('other_user_id', other_user_id);
    fetch('/update_chat', {
        method: 'POST',
        body: fd
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            return response.text();
        })
        .then(data => {
            document.getElementsByClassName('chat__wrapper')[0].innerHTML = JSON.parse(data);
        })
}, 2000)