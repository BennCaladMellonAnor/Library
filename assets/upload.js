function uploadEbook(e, element){
	e.preventDefault()
	let input = document.querySelector("#inputHidden");
	element.toggleAttribute("disabled")
	input.click();

	const reader = new FileReader();

	var file = setInterval(()=>{
		if (input.files[0]) {
			clearInterval(file);
			//Enviar o fomulário
			alert("Seu EBOOK foi carregado!!! \n Aguarde Até o Administrador Catalogar o Ebook... \n Clique em 'OK' para continuar");
			input.parentNode.submit()

		}
	}, 1000);
}

function view(e, element){
	e.preventDefault();
	let div = element.nextElementSibling
	let form = div.firstElementChild
	let input = form.firstElementChild
	input.parentNode.submit();
}