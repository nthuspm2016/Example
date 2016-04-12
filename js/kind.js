function kind($kk){
	$.ajax( {
		url: 'model/kind.php',
		type: 'POST',
		data: {
			kind:$kk
		},
		error: function(xhr) {
			alert('Server忙碌中,請稍候再試');
		},
		success: function(response) {
            $('.kind').removeClass('active');
            $('#'+$kk).addClass('active');
            infload();
		}
	} );
};
