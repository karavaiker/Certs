// Esnure the $ works with jQuery
    var $ = jQuery.noConflict();

// Function of tabs switching

    function switch_tables(numb){
        $('#tbl1').css('display','none');
		$('#tbl2').css('display','none');
		$('#tbl3').css('display','none');
		  
		$('#tb_tab1').removeClass('active');
		$('#tb_tab2').removeClass('active');
		$('#tb_tab3').removeClass('active');
		  
		$('#tbl'+numb).css('display','block');
		$('#tb_tab'+numb).addClass('active');
		
		return false;
    };
		
// Function of table items sorting
		
	$(document).ready(function() { 
		$("#actual-certs-table").tablesorter({sortList: [[4,1]]});
		$("#closed-certs-table").tablesorter();
		$("#nopaid-certs-table").tablesorter();
	});