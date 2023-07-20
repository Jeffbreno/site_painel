// Função para abrir a modal de confirmação
function abrirModalConfirmacao() {
  // const modal = document.getElementById('modal-confirmacao');
  const modal = document.getElementById('modal-confirmacao');
  if (modal) {
    let bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
  }
}

// Função para fechar a modal de confirmação
function fecharModalConfirmacao() {
  const modal = $("#modal-confirmacao");
  if (modal) {
    modal.modal('hide');
  }
}

// Evento para abrir a modal de confirmação quando um botão de exclusão for clicado
const botoesExclusao = document.querySelectorAll(".btn-excluir");
botoesExclusao.forEach((botao) => {
  botao.addEventListener("click", (event) => {
    event.preventDefault();
    const idDoItem = botao.getAttribute("data-id");
    abrirModalConfirmacao();

    // Implemente aqui a lógica para realizar a exclusão do item com o ID "idDoItem"
    // Fazer requisição AJAX e atualizar a tela do sistema, se necessário
    // ...
  });
});

// Evento para fechar a modal de confirmação quando o botão "Cancelar" for clicado
document.getElementById("btn-confirmar-exclusao").addEventListener("click", () => {
  // Coloque aqui o código para fazer a requisição AJAX e excluir o item do banco de dados
  // ...
  console.log("excluir item");
  // Após a exclusão, você pode implementar a lógica para atualizar a tela do sistema
  // por exemplo, removendo o item excluído da lista
  // ...

  // Fechar a modal de confirmação após a exclusão (ou tratar a resposta da requisição AJAX)
  fecharModalConfirmacao();
});

// Evento para fechar a modal de confirmação quando o botão "Cancelar" for clicado
const botaoExclusao = document.getElementById("btn-cancelar-exclusao");
if (botaoExclusao) {
  botaoExclusao.addEventListener("click", () => {
    fecharModalConfirmacao();
  });
}
