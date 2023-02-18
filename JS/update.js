// déclaration de variables récupérées via les id
const container = document.getElementById("container");
let update = document.querySelector("#update");
let profilForm = document.querySelector("#profilForm");

// lorsque l'on clique sur post, tu lances la fonction qui ajoute le texte de succès dans html
update.addEventListener("click", async (event) => {
  event.preventDefault();
  fetch("profil.php", {
    method: "POST",
    body: new FormData(profilForm),
  })
    .then((resp) => {
      return resp.text();
    })
    .then((content) => {
      let updating = document.getElementById("updating");
      updating.innerHTML = content;
      updating.style.color = "#FAC9B8";
      uError.textContent = "";

      // // redirection
      // setTimeout(function () {
      //   window.location.href = "livre-or.php";
      // }, 2000);
    });
});
