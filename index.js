// Open modal
function abreModal() {
	$("#modalCriar").css("display", "block");
}

// Close modal
function fechaModal() {
	$("#modalCriar").css("display", "none");
	$("#modalDelete").css("display", "none");
	$("#modalConclui").css("display", "none");
}

// Close modal when press "Esc"
$(document).keyup(function(e) {
	if (e.key === "Escape")
		fechaModal();
});

// Register post interactions
function interagePost(id, recom, naorecom) {
	$.ajax
	({
		type: "POST",
		dataType : 'json',
		url: './grava-post.php',
		data: {id: id, recom: recom, naorecom: naorecom}
	});

	$("#S"+id).attr("href", "javascript:interagePost("+id+", "+recom+", "+naorecom+")");
	$("#N"+id).attr("href", "javascript:interagePost("+id+", "+recom+", "+(naorecom+1)+")");
	$("#N"+id).html(naorecom+" <i class='fa-solid fa-thumbs-down'></i>");
	$("#R"+id).attr("href", "javascript:interagePost("+id+", "+(recom+1)+", "+naorecom+")");
	$("#R"+id).html(recom+" <i class='fa-solid fa-thumbs-up'></i>");
}

// Delete post
function deletePost(id, titulo, descricao, tipo) {
	$("#idD").val(id);
	$("#tituloD").val(titulo);
	$("#descricaoD").val(descricao);
	$("#tipoD").val(tipo);
	$("#modalDelete").css("display", "block");
}

// Conclude post
function conlcuirPost(id, titulo, descricao, tipo) {
	$("#idC").val(id);
	$("#tituloC").val(titulo);
	$("#descricaoC").val(descricao);
	$("#tipoC").val(tipo);
	$("#modalConclui").css("display", "block");
}