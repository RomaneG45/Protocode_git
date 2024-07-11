document.addEventListener("DOMContentLoaded", function() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('message') && params.get('message') === 'success') {
        const messageContainer = document.getElementById('message-container');
        const messageParagraph = document.createElement('p');
        messageParagraph.textContent = "The new protocol has been added successfully.";
        messageParagraph.style.color = 'red';
        messageContainer.appendChild(messageParagraph);
    }

    // Code pour changer le label du bouton de fichier
    const fileInput = document.getElementById('file');
    const fileLabel = document.getElementById('file-label');

    fileInput.addEventListener('change', function() {
        const fileName = this.files[0].name;
        fileLabel.textContent = fileName ? fileName : 'Choose a file';
    });
});
