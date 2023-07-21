(function (doc) {
  "use strict";

  function excluirItem(idDoItem) {
    console.log(idDoItem);
    // Fazer a requisição AJAX para excluir o item
    // fetch("/admin/testimonies/" + 0 + "/delete", {
    //   method: "POST",
    // })
    //   .then((response) => {
    //     if (response.ok) {
    //       console.log(response);
    //       // Se a exclusão foi bem-sucedida, remover o item da lista na tela
    //       const linhaExcluida = document.querySelector(`tr[data-id="${idDoItem}"]`);
    //       if (linhaExcluida) {
    //         linhaExcluida.remove();
    //       }
    //     } else {
    //       // Tratar o erro ou mostrar uma mensagem de falha
    //       console.error("Falha ao excluir o item.");
    //     }
    //   })
    //   .catch((error) => {
    //     // Tratar erros de requisição, caso ocorram
    //     console.error("Erro na requisição:", error);
    //   });
  }

  // Evento para excluir o item quando um botão de exclusão for clicado
  const botoesExclusao = doc.querySelectorAll(".btn-excluir");
  botoesExclusao.forEach((botao) => {
    botao.addEventListener("click", (event) => {
      event.preventDefault(); // Impede a ação padrão do botão (se houver)
      const idDoItem = botao.getAttribute("data-id");

      abrirModalConfirmacao(idDoItem);
    });
  });

  // Função para abrir a modal de confirmação
  let handlerExcluir = null;
  function abrirModalConfirmacao(idDoItem) {
    $("#modal-confirmacao").modal("show");
    let botaoExclusao = doc.getElementById("btn-confirmar-exclusao");
    if (handlerExcluir) {
      botaoExclusao.removeEventListener("click", handlerExcluir);
    }

    handlerExcluir = () => {
      // Chamar a função de exclusão passando o idDoItem
      excluirItem(idDoItem);
      // Fechar a modal após a exclusão
      $("#modal-confirmacao").modal("hide");
    };

    botaoExclusao.addEventListener("click", handlerExcluir);
  }
})(document);
