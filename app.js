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
            body: formData,
        })

        .then((response) => {
            // Controleer expliciet of de response JSON is
            if (!response.ok) {
                throw new Error(`HTTP-fout: ${response.status}`);
            }
            return response.json(); //Parse de JSON response
        })
        .then((result) => {
            console.log(result); // Bekijk de serverrespons in de browser-console

            //Controleer op serverstatus
            if (result.status === "success") {
                // Dynamisch toevoegen aan de lijst
                let reviewList = document.querySelector(`#reviewList-${productId}`);

                //Nieuw review toevoegen
                reviewList.innerHTML = ""

                //Controleren of er reviews zijn en voeg ze toe
                if(Array.isArray(result.reviews)){
                    result.reviews.forEach(review => {
                        let reviewItem = document.createElement("li");
                        reviewItem.innerHTML = 
                        `<strong>Rating:</strong> ${review.rating} / 5<br>
                         <strong>Review:</strong> ${review.comment}<br>
                       <small>${review.created_at}</small>`;
                    reviewList.appendChild(reviewItem);  
                    });
                }
                // Formulier leegmaken
                form.reset();
            } else {
                // Toon foutmelding van de server
                alert(result.message);
            }
        })
        .catch((error) => {
            console.error("Fout tijdens verwerking:", error);
            alert("Er is een fout opgetreden bij het verwerken van de review.");
        });
    });
});