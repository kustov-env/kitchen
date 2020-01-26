jQuery(document).ready(function($){
    $('#btn').click(function(){
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                data: id,
                action: 'delete_admin'
            },
            success: function(res){
                if(res) {
                    location.reload();
                }


            },
            error: function(){
                alert('Ошибка!');
            }
        });
    });
});
