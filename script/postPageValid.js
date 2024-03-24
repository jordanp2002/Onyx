 // Function to validate the comment before submission
    function validateComment() {
        var comment = document.getElementById('userComment').value.trim();

        // Check if the comment is empty
        if (comment === '') {
            alert('Please enter a comment.');
            return false;
        }

        return true;
    }

    // Add event listener to the comment button
    document.querySelector('.button.comment').addEventListener('click', function() {
        // Validate the comment before submitting
        if (!validateComment()) {
            return;
        }

        // If validation passes, submit the form or perform other actions
        console.log('Comment submitted successfully.');
    });