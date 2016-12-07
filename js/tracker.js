function visit(page) {

    $.ajax({

        type: 'POST',
        url:  '/includes/tracker/visitor.php',
        data: {

            page: pagename,
            date: new Date();

        }

    });

}

$(document).ready(function(){

    visit(pagename);

});