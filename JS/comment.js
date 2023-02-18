// déclaration de variables récupérées via les id
const container = document.getElementById("container");
let post = document.querySelector("#post");
let commentForm = document.querySelector("#commentForm");

// lorsque l'on clique sur post, tu lances la fonction qui ajoute le texte de succès dans html
post.addEventListener("click", async (event) => {
  event.preventDefault();
  fetch("commentaire.php", {
    method: "POST",
    body: new FormData(commentForm),
  })
    .then((resp) => {
      return resp.text();
    })
    .then((content) => {
      let posting = document.getElementById("posting");
      posting.innerHTML = content;
      posting.style.color = "#FAC9B8";
      cError.textContent = "";

      // // redirection
      // setTimeout(function () {
      //   window.location.href = "livre-or.php";
      // }, 2000);
    });
});
