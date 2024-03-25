function validateSearch() {
    var searchInput = document.getElementById("searchInput").value.trim();

    if (searchInput === "") {
        alert("Please enter a search query.");
        return false;
    }

    //Proceed with the search
    alert("Searching for: " + searchInput);
    return true;
}