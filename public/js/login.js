document.addEventListener('DOMContentLoaded', function() {

    document.querySelector('form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            const jsonResponse = await response.json();
            alert(jsonResponse.echec);
        } else {
            window.location.href = HOME_URL;
        }
    });
});