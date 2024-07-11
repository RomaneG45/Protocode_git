/* Displays the message "The new protocol has been added successfully." when the pdf is submitted. 
Updates the file search button with the name of the chosen protocol
HTML file : "upload.html"
Php file : "upload.php" */


document.addEventListener("DOMContentLoaded", function() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('message') && params.get('message') === 'success') {
        const messageContainer = document.getElementById('message-container');
        const messageParagraph = document.createElement('p');
        messageParagraph.textContent = "The new protocol has been added successfully.";
        messageParagraph.style.color = 'red';
        messageContainer.appendChild(messageParagraph);
    }

    // Code to change the file button label
    const fileInput = document.getElementById('file');
    const fileLabel = document.getElementById('file-label');

    fileInput.addEventListener('change', function() {
        const fileName = this.files[0].name;
        fileLabel.textContent = fileName ? fileName : 'Choose a file';
    });
});
