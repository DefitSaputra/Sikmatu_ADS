document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const stars = document.getElementById('stars').value;
    const message = document.getElementById('message').value;

    if (!email || !stars || !message) {
        e.preventDefault();
        alert('Semua field harus diisi!');
    }
});
