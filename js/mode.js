function mode($kk){
	$.ajax( {
		url: 'model/mode.php',
		type: 'POST',
		data: {
			kind:$kk
		},
		error: function(xhr) {
			alert('Server忙碌中,請稍候再試');
		},
		success: function(response) {
            $('.mode').removeClass('active');
            $('#'+$kk).addClass('active');
            infload();
		}
	} );
};
