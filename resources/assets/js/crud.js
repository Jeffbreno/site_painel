(function (win, doc) {
  "use scrict";

  //Delete
  function confirmDel(url, bootstrapModal) {
    console.log("delete " + url);
    bootstrapModal.hide();
  }

  //exibir modal de confirmação da exclusão
  function exibirModalConfirmacao(event) {
    event.preventDefault();

    var modal = $("#confirmDeleteModal");
    var bootstrapModal = new bootstrap.Modal(modal);

    let url = event.target.href;

    bootstrapModal.show();

    let btnConfirmar = document.getElementById("btnConfirmar");
    btnConfirmar.addEventListener("click", function () {
      confirmDel(url, bootstrapModal);
    });
  }

  if (doc.querySelector(".js-del")) {
    let btn = doc.querySelectorAll(".js-del");

    for (let i = 0; i < btn.length; i++) {
      btn[i].addEventListener("click", exibirModalConfirmacao);
    }
  }
})(window, document);
