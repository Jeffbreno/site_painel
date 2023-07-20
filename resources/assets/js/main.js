// Função para abrir a modal de confirmação
function abrirModalConfirmacao(idDoItem) {
  // const modal = document.getElementById('modal-confirmacao');
  const modal = document.getElementById("modal-confirmacao");
  if (modal) {
    let bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    excluirItem(idDoItem);
  }
}

// Função para fechar a modal de confirmação
function fecharModalConfirmacao() {
  const modal = $("#modal-confirmacao");
  if (modal) {
    modal.modal("hide");
  }
}

// Evento para abrir a modal de confirmação quando um botão de exclusão for clicado
const botoesExclusao = document.querySelectorAll(".btn-excluir");
botoesExclusao.forEach((botao) => {
  botao.addEventListener("click", (event) => {
    event.preventDefault();
    delete window.idDoItem;
    idDoItem = botao.getAttribute("data-id");
    //ABRE A TELA MODAL E ENVIA O ID DE EXCLUSÃO
    abrirModalConfirmacao(idDoItem);
  });
});

function excluirItem(id) {
  const botaoExclusao = document.getElementById("btn-confirmar-exclusao");
  botaoExclusao.addEventListener("click", () => {
    // Realizar a solicitação AJAX
    $.ajax({
      url: '/admin/testimonies/'+id+'/delete', 
      type: "POST",
      //dataType: "json", // Define o tipo de dados que espera receber como resposta
      success: function (response) {
        // Função executada em caso de sucesso
        console.log("Resposta do servidor:", response);
        alert("Dados enviados com sucesso!");
      },
      error: function (xhr, status, error) {
        // Função executada em caso de erro
        console.error("Erro na solicitação AJAX:", error);
        alert("Ocorreu um erro ao enviar os dados.");
      },
    });
    fecharModalConfirmacao();
  });
}

// Evento para fechar a modal de confirmação quando o botão "Cancelar" for clicado
const botaoCancelar = document.getElementById("btn-cancelar-exclusao");
if (botaoCancelar) {
  botaoCancelar.addEventListener("click", () => {
    fecharModalConfirmacao();
  });
}
