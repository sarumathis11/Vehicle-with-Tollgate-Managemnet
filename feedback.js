document.getElementById('feedbackForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('feedback.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        this.reset();
    })
    .catch(error => {
        console.error('Error submitting feedback:', error);
        alert('Something went wrong. Please try again later.');
    });
});
