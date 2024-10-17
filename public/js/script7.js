function logout(){
	swal({
		title: "Sair da conta?",
  		dangerMode: true,
		icon: "info",
		buttons: {
			cancel: {
			    text: "Cancelar",
			    value: false,
			    visible: true,
			    className: "",
			    closeModal: true,
			  },
			confirm: {
				text: "Sair",
			    value: true,
			    visible: true,
			    className: 'sair',
			    closeModal: true,
			}
		},
	}).then((value) => {
		if(value){
			window.location.href = "sair";
		}
	});
}

$(document).ready(function(){

	$('.fa-sign-out-alt').click(()=>{
		
		logout()

	})

})