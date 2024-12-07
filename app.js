document.querySelectorAll(".review-form").forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        //Krijg de product_id vanuit data-attribuut
        let productId = form.dataset.productId;
        let formData = new FormData(form);
        formData.append("product_id", productId);

        //Verzend de review naar de server
        fetch("submitReview.php", {
            method: "POST",
            body: formData
        })

        .then(response => {
            // Controleer expliciet of de response JSON is
            if (!response.ok) {
                throw new Error(`HTTP-fout: ${response.status}`);
            }
            return response.json(); // Mogelijke fout 4: Als de server geen JSON retourneert
        })
        .then(result => {
            if (result.status === "success") {
                // Dynamisch toevoegen aan de lijst
                let reviewList = document.querySelector(`#reviewList-${productId}`);
                let newReview = document.createElement("li");
                newReview.innerHTML = 
                `<strong>Rating:</strong> ${result.review.rating} / 5<br>
                 <strong>Review:</strong> ${result.review.comment}`;
                reviewList.appendChild(newReview);

                // Formulier leegmaken
                form.reset();
            } else {
                // Toon foutmelding van de server
                alert(result.message);
            }
        })
        .catch((error) => {
            console.error("Fout tijdens verwerking:", error);
            fetch("submitReview.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.text()) // Hier gebruik je text() om de exacte output te krijgen
            .then(text => console.error("Server response (RAW):", text));
            alert("Er is een fout opgetreden bij het toevoegen van de review");
        });
    });
});