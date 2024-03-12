 $(function() {		
	
	var table;
	
	$(document).ready(function(){		
		table =	dadosTabela();
	});
	
	$('#tableOrders').on('keyup', function () {
    $('#tableOrders').search(this.value).draw();
	});	

});


function dadosTabela(paramentro1 = null,paramentro2 = null,paramentro3 = null){	

		$('#tableOrders').DataTable( {	
			  destroy:true,
			  responsive: true,
			 	processing: true,
        serverSide: true,	
			  stateSave: true, 
				stateDuration: 20,
				paging: true,				
				pagingType: 'full_numbers',
				searching: true,
	   		bSort: true,
			  order: [0, 'DESC'],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],   
				pageLength: 25,
				ordering: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
				language: {
 					url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json'
				},
			dom: 'Blfrtip',
						 buttons: [
							 'print',
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
        ],
				ajax: {
					url: document.baseURI,	
					type: 'POST',	
					data: {
						action: 'otimizar',
						paramentro1:paramentro1,
						paramentro2:paramentro2,
						paramentro3:paramentro3
					}
				},			
				deferRender: true,
		});		
}



      