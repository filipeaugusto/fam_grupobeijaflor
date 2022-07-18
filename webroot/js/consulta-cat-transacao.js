function pesquisacat(valor) {

    $.ajax({
        url: "/admin/partners/getExpenseCategory/" + valor,
        type: "GET",
        dataType: "json"
    }).done(function(resposta) {
        $("select.resultExpenseCategory").val(resposta.partner.expense_category_id);
        console.log("Request done: " + resposta.partner.name);
    }).fail(function(jqXHR, textStatus ) {
        console.log("Request failed: " + textStatus);
        $("select.resultExpenseCategory").val(null);
    }).always(function() {
        console.log("completou");
    });
};
