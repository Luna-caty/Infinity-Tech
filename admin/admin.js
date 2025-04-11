const productForm = document.querySelector(".product-form");
const moreDetailsText = document.getElementById("more-detail-text");
const PCMoreDetails = document.querySelector(".PC_more_details");
const PhonesMoreDetails = document.querySelector(".Phones_more_details");
const AccessoryMoreDetails = document.querySelector(".accessory_more_details");
const ComposantMoreDetails = document.querySelector(".composant_more_details");
PCMoreDetails.style.display = "none";
PhonesMoreDetails.style.display = "none";
AccessoryMoreDetails.style.display = "none";
ComposantMoreDetails.style.display = "none";

productForm.addEventListener("change", function (event) {
  if (event.target.name === "category") {
    const selectedCategory = event.target.value;
    if (selectedCategory === "laptop") {
      PCMoreDetails.style.display = "block";
      PhonesMoreDetails.style.display = "none";
      AccessoryMoreDetails.style.display = "none";
      ComposantMoreDetails.style.display = "none";
    } else if (selectedCategory === "smartphone") {
      PCMoreDetails.style.display = "none";
      PhonesMoreDetails.style.display = "block";
      AccessoryMoreDetails.style.display = "none";
      ComposantMoreDetails.style.display = "none";
    } else if (selectedCategory === "accessoire") {
      PCMoreDetails.style.display = "none";
      PhonesMoreDetails.style.display = "none";
      AccessoryMoreDetails.style.display = "block";
      ComposantMoreDetails.style.display = "none";
    } else if (selectedCategory === "composant") {
      PCMoreDetails.style.display = "none";
      PhonesMoreDetails.style.display = "none";
      AccessoryMoreDetails.style.display = "none";
      ComposantMoreDetails.style.display = "block";
    }
  }
});
