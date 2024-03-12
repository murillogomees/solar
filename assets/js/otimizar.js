    $('#usuarioFrete').on('change', function(){
      var usuario = this.value;
			console.log(usuario);
		   dadosTabela(usuario);
    });

function botaoaviao(id){
	var selectuser = document.getElementById('usuarioFrete');
	var id_usuario =  selectuser.value;
				dadosTabela(id_usuario,id);
			}

function botaotruck(id){
  var idaviao;
	var selectuser = document.getElementById('usuarioFrete');
	var id_usuario =  selectuser.value;
				dadosTabela(id_usuario,idaviao = null,id);
	
			}