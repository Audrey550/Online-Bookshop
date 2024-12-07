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

            .then(response => response.json())
            .then(result => {
                if(result.status === "success") {
                    
                    //Dynamisch toevoegen aan de lijst
                    let reviewList = document.querySelector(`#reviewList-${productId}`);
                    let newReview = document.createElement("li");
                    newReview.innerHTML = 
                    `<strong>Rating:</strong>${result.review.rating} / 5<br>
                    <strong>Review:</strong>${result.review.comment}
                    `;
                    reviewList.appendChild(newReview);

                    //Formulier leegmaken
                    form.reset();
                } else {
                    alert(result.message);
                }
            })
            .catch(error => 
                {console.error("Fout:", error);
                    alert("Er is een fout opgetreden bij het toevoegen van de review");
                });
        });
});