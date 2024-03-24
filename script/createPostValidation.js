 function validateAndSubmit() {
            const postTitle = document.getElementById('postTitle').value.trim();
            const postContent = document.getElementById('postContent').value.trim();

            if (postTitle.length < 1) {
                alert('Please enter a post title with at least 2 characters.');
                return;
            }

            if (postContent.length < 1 || postContent.length > 500) {
                alert('Please enter post content between 10 and 500 characters.');
                return;
            }

            // If all validations pass, proceed with form submission
            alert('Post submitted successfully!');
            //add code here to submit the form to the server
        }

        function clearFields() {
            document.getElementById('postTitle').value = '';
            document.getElementById('postContent').value = '';
        }