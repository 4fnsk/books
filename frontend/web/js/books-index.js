if (localStorage.lastHref) {
    var href = localStorage.lastHref;
    localStorage.removeItem('lastHref');
    location.assign(href);
}
window.onload = function(){
    $('.scalable').on('click', function(){
        var img = $('<img />', {
            src: $(this).attr('src'),
            alt: 'preview',
            'class': 'img-w100'
        });
        $('#modal-content').empty().append(img);
        $('#modal-window').modal('show');
    });

    $('.a-view').on('click', function(){
        var id = $(this).parent().data('id');

        $.ajax( "/books/view?id=" + id )
            .done(function(data) {
                $('#modal-content').html(data);
            })
            .fail(function() {
                $('#modal-content').html('Something is wrong..');
            });
    });

    $('.a-remove').on('click', function(){
        var id = $(this).parent().data('id');

        $.ajax( "/books/delete?id=" + id );
        location.reload();
    });

    $('.a-edit').on('click', function(){
        var id = $(this).parent().data('id');
        localStorage.setItem("lastHref", location.href);
        location.assign('/books/update?id=' + id);
    });
};
