function infload() {
    var $container = $('#content');
    $container.isotope({
        itemSelector : '.element'
    });
    $container.infinitescroll({
        navSelector  : '#next:last',    // selector for the paged navigation
        nextSelector : 'a#next:last',  // selector for the NEXT link (to page 2)
        itemSelector : '.element',     // selector for all items you'll retrieve
        loading: {
            start: function(options) {
                $('#loading').show();
                // Do something here.
                $(this).data('infinitescroll').beginAjax(options)
            },
            finished: function() {
                $('#loading').hide();
                $container.infinitescroll('pause');
                // Do something here.
            }
        },
        errorCallback: function(errorType) {
            if (errorType == "done") {
                $('#loading').removeClass('glyphicon-refresh');
                $('#loading').removeClass('glyphicon-refresh-animate');
                $('#loading').addClass('glyphicon-ok');
                clearInterval(ss);
            }
        },
    },
    // call Isotope as a callback
    function( newElements ) {
        $container.isotope( 'insert', $( newElements ) );
    }
    );
}
function getkind(){
    $.ajax( {
        url: 'model/get.php',
        type: 'POST',
        data: {
            id:'kind'
        },
        error: function(xhr) {
            alert('Server忙碌中,請稍候再試');
        },
        success: function(response) {
            $('#'+response).addClass('active');
            $('#now').html($('#'+response).text());
        }
    } );
};
function getmode(){
    $.ajax( {
        url: 'model/get.php',
        type: 'POST',
        data: {
            id:'mode'
        },
        error: function(xhr) {
            alert('Server忙碌中,請稍候再試');
        },
        success: function(response) {
            $('#'+response).addClass('active');
        }
    } );
};
function mode($kk){
    $('#'+$kk).addClass('active');
    $.ajax( {
        url: 'model/mode.php',
        type: 'POST',
        data: {
            mode:$kk
        },
        error: function(xhr) {
            alert('Server忙碌中,請稍候再試');
        },
        success: function(response) {
            location.reload();
        }
    } );
};
function kind($kk){
    $('#'+$kk).addClass('active');
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
            location.reload();
        }
    } );
};
$(document).ready(function (){
    getkind();
    getmode();
    infload();
    $(document).scroll();
});
function layout(){
    var $container = $('#content');
    var arr=[];
    var $d=$('<div class="element" style="display:none;" />');
    arr.push($d[0]);
    $container.isotope( 'insert', $( arr ) );
}
setInterval(layout,3000);
function scroll(){
    var $container = $('#content');
    if($(window).scrollTop() + window.innerHeight + 1000 > $('#content').height()) {
        $container.infinitescroll('resume');
        $(document).scroll();
    }
}
var ss=setInterval(scroll,500);
